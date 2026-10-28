<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class CarDetailMetaImageTest extends TestCase
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
        return User::factory()->create(['role' => 'admin', 'email' => 'meta-'.uniqid().'@example.test']);
    }

    private function makeImage(Car $car, bool $isMain, int $sortOrder): CarImage
    {
        return $car->images()->create([
            'path' => 'storage/cars/meta-'.uniqid().'.jpg',
            'is_main' => $isMain,
            'sort_order' => $sortOrder,
        ]);
    }

    private function payload(Car $car): array
    {
        return [
            'name' => $car->name,
            'seats' => $car->seats,
            'transmission' => $car->transmission,
            'fuel' => $car->fuel,
            'price_per_day' => $car->price_per_day,
            'price_per_session' => $car->price_per_session,
            'status' => $car->status,
        ];
    }

    private function metaContent(string $html, string $attribute, string $value): string
    {
        $pattern = '/<meta\s+'.$attribute.'="'.preg_quote($value, '/').'"\s+content="([^"]*)"/';
        preg_match($pattern, $html, $matches);

        $this->assertNotEmpty($matches[1] ?? null, "Meta {$attribute}=\"{$value}\" not found in response.");

        return $matches[1];
    }

    public function test_meta_image_follows_main_image_set_from_admin(): void
    {
        $car = Car::factory()->create();
        $first = $this->makeImage($car, true, 0);
        $second = $this->makeImage($car, false, 1);

        $html = $this->get(route('car-detail', $car->slug))->assertOk()->getContent();

        $this->assertStringEndsWith($first->path, $this->metaContent($html, 'property', 'og:image'));
        $this->assertStringEndsWith($first->path, $this->metaContent($html, 'name', 'twitter:image'));

        $this->actingAs($this->admin())
            ->put(route('admin.cars.update', $car), array_merge($this->payload($car), [
                'image_order' => ['existing:'.$second->id, 'existing:'.$first->id],
            ]))
            ->assertRedirect(route('admin.cars.index'));

        $this->assertFalse($first->fresh()->is_main);
        $this->assertTrue($second->fresh()->is_main);

        $car->refresh();

        $html = $this->get(route('car-detail', $car->slug))->assertOk()->getContent();

        $ogImage = $this->metaContent($html, 'property', 'og:image');
        $twitterImage = $this->metaContent($html, 'name', 'twitter:image');

        $this->assertStringEndsWith($second->path, $ogImage);
        $this->assertStringEndsWith($second->path, $twitterImage);
        $this->assertStringNotContainsString($first->path, $ogImage);
        $this->assertStringContainsString(asset($second->path), $html);
    }

    public function test_meta_image_falls_back_to_first_image_when_no_main_flag(): void
    {
        $car = Car::factory()->create();
        $this->makeImage($car, false, 2);
        $first = $this->makeImage($car, false, 0);

        $html = $this->get(route('car-detail', $car->slug))->assertOk()->getContent();

        $this->assertStringEndsWith($first->path, $this->metaContent($html, 'property', 'og:image'));
        $this->assertStringEndsWith($first->path, $this->metaContent($html, 'name', 'twitter:image'));
    }

    public function test_meta_image_uses_default_banner_when_car_has_no_image(): void
    {
        $car = Car::factory()->create();

        $html = $this->get(route('car-detail', $car->slug))->assertOk()->getContent();

        $this->assertStringEndsWith('assets/image/bannerMXH.jpg', $this->metaContent($html, 'property', 'og:image'));
    }
}
