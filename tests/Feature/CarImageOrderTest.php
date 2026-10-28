<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CarImageOrderTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        if (Config::get('database.default') === 'sqlite') {
            $this->markTestSkipped('Skipped on SQLite: project migrations are MySQL-only.');
        }
    }

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin', 'email' => 'cars-' . uniqid() . '@example.test']);
    }

    private function uploadedImage(): UploadedFile
    {
        return new UploadedFile(
            __DIR__ . '/../Fixtures/1x1.jpg',
            'pic.jpg',
            'image/jpeg',
            null,
            true
        );
    }

    private function payload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Toyota Vios Test ' . uniqid(),
            'seats' => 5,
            'transmission' => 'Tự động',
            'fuel' => 'Máy xăng',
            'price_per_day' => 700000,
            'price_per_session' => 350000,
            'status' => 'available',
        ], $overrides);
    }

    private function makeImage(Car $car, bool $isMain, int $sortOrder): CarImage
    {
        return $car->images()->create([
            'path' => 'storage/cars/test-' . uniqid() . '.jpg',
            'is_main' => $isMain,
            'sort_order' => $sortOrder,
        ]);
    }

    public function test_create_sets_first_uploaded_image_as_main(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.cars.store'), $this->payload([
                'images' => [$this->uploadedImage(), $this->uploadedImage()],
            ]))
            ->assertRedirect(route('admin.cars.index'));

        $car = Car::latest('id')->firstOrFail();
        $images = $car->images()->orderBy('sort_order')->get();

        $this->assertCount(2, $images);
        $this->assertTrue($images[0]->is_main);
        $this->assertFalse($images[1]->is_main);
    }

    public function test_update_can_change_main_to_another_existing_image(): void
    {
        Storage::fake('public');

        $car = Car::factory()->create();
        $first = $this->makeImage($car, true, 0);
        $second = $this->makeImage($car, false, 1);

        $this->actingAs($this->admin())
            ->put(route('admin.cars.update', $car), $this->payload([
                'image_order' => ['existing:' . $second->id, 'existing:' . $first->id],
            ]))
            ->assertRedirect(route('admin.cars.index'));

        $this->assertTrue($second->fresh()->is_main);
        $this->assertFalse($first->fresh()->is_main);
        $this->assertSame(0, $second->fresh()->sort_order);
        $this->assertSame(1, $first->fresh()->sort_order);
    }

    public function test_update_can_set_new_upload_as_main(): void
    {
        Storage::fake('public');

        $car = Car::factory()->create();
        $existing = $this->makeImage($car, true, 0);

        $this->actingAs($this->admin())
            ->put(route('admin.cars.update', $car), $this->payload([
                'images' => [$this->uploadedImage()],
                'image_order' => ['new:0', 'existing:' . $existing->id],
            ]))
            ->assertRedirect(route('admin.cars.index'));

        $car->refresh();
        $this->assertCount(2, $car->images);
        $this->assertFalse($existing->fresh()->is_main);

        $main = $car->images()->where('is_main', true)->firstOrFail();
        $this->assertNotSame($existing->id, $main->id);
        $this->assertSame(0, $main->sort_order);
    }

    public function test_update_without_sort_order_keeps_existing_main(): void
    {
        Storage::fake('public');

        $car = Car::factory()->create();
        $first = $this->makeImage($car, true, 0);
        $this->makeImage($car, false, 1);

        $this->actingAs($this->admin())
            ->put(route('admin.cars.update', $car), $this->payload())
            ->assertRedirect(route('admin.cars.index'));

        $this->assertTrue($first->fresh()->is_main);
    }
}
