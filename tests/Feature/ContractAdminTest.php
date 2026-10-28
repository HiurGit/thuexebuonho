<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContractAdminTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // The project's migrations use MySQL-only syntax (MODIFY COLUMN ... ENUM),
        // so the contract suite only runs against a MySQL connection (phpunit.mysql.xml).
        if (Config::get('database.default') === 'sqlite') {
            $this->markTestSkipped('Skipped on SQLite: project migrations are MySQL-only.');
        }
    }

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin', 'email' => 'smoke-' . uniqid() . '@example.test']);
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

    private function uploadedVideo(): UploadedFile
    {
        return new UploadedFile(
            __DIR__ . '/../Fixtures/min.mp4',
            'vid.mp4',
            'video/mp4',
            null,
            true
        );
    }

    private function contractPayload(Car $car = null): array
    {
        return [
            'status' => 'active',
            'branch' => '07 Chu Văn An, Buôn Hồ',
            'cccd' => '067123456789',
            'customer_name' => 'Nguyễn Văn A',
            'customer_phone' => '0912345678',
            'dob' => '1995-06-15',
            'gender' => 'Nam',
            'cccd_issue_date' => '2020-01-01',
            'cccd_issue_place' => 'Đắk Lắk',
            'customer_address' => 'Buôn Hồ, Đắk Lắk',
            'driver_license_no' => 'B2-123456',
            'license_issue_date' => '2019-05-05',
            'license_expiry_date' => '2029-05-05',
            'license_class' => 'B2',
            'car_id' => $car?->id,
            'car_name' => $car?->name ?? 'Toyota Vios',
            'car_plate' => '47A-123.45',
            'car_seats' => 5,
            'car_transmission' => 'Tự động',
            'car_fuel' => 'Máy xăng',
            'car_year' => 2020,
            'pickup_datetime' => '2026-09-18T08:00',
            'pickup_location' => '07 Chu Văn An',
            'return_datetime' => '2026-09-20T08:00',
            'return_location' => '07 Chu Văn An',
            'total_days' => 2,
            'total_hours' => 0,
            'km_limit' => 300,
            'deposit_type' => 'cash',
            'deposit_amount' => 2000000,
            'deposit_note' => '',
            'daily_rate' => 700000,
            'rental_days' => 2,
            'total_rental_fee' => 1400000,
            'notes' => 'Ghi chú test',
        ];
    }

    public function test_admin_can_view_contract_index(): void
    {
        Storage::fake('public');
        Contract::factory()->create(['customer_name' => 'ABC Khách', 'status' => 'pending']);

        $this->actingAs($this->admin())
            ->get(route('admin.contracts.index'))
            ->assertOk()
            ->assertSee('ABC Khách');
    }

    public function test_admin_can_view_create_page(): void
    {
        Storage::fake('public');
        $this->actingAs($this->admin())
            ->get(route('admin.contracts.create'))
            ->assertOk()
            ->assertSee('Thông tin khách hàng')
            ->assertSee('Ngày sinh')
            ->assertSee('Giới tính')
            ->assertSee('Thông tin thuê')
            ->assertSee('Lộ trình di chuyển')
            ->assertSee('Số ghế')
            ->assertSee('Hộp số')
            ->assertSee('Nhiên liệu')
            ->assertSee('Biển số')
            ->assertSee('money-input')
            ->assertSee('Ảnh CCCD')
            ->assertSee('Ảnh bằng lái')
            ->assertSee('mặt trước, ảnh thứ hai = mặt sau')
            ->assertSee('Đổi vị trí mặt trước/sau')
            ->assertSee('images_cccd_front')
            ->assertSee('images_cccd_back')
            ->assertSee('Thêm ảnh tải lên')
            ->assertSee('__CONTRACT_OCR')
            ->assertSee('ocr-gemini')
            ->assertSee('ocr-openai')
            ->assertSee('contract-card-reader')
            ->assertSee('js-datetime-picker')
            ->assertSee('js-date-picker')
            ->assertSee('flatpickr.min.js');
    }

    public function test_admin_can_create_contract_with_images(): void
    {
        Storage::fake('public');
        $car = Car::factory()->create();

        $payload = $this->contractPayload($car);
        $payload['images_cccd_front'][] = $this->uploadedImage();
        $payload['images_cccd_back'][] = $this->uploadedImage();
        $payload['images_license_front'][] = $this->uploadedImage();
        $payload['images_license_back'][] = $this->uploadedImage();
        $payload['images_car_before'][] = $this->uploadedImage();
        $payload['images_car_video'][] = $this->uploadedVideo();
        $payload['images_car_video'][] = $this->uploadedImage();

        $this->actingAs($this->admin())
            ->post(route('admin.contracts.store'), $payload)
            ->assertRedirect();

        $contract = Contract::latest('id')->firstOrFail();
        $this->assertSame('Nguyễn Văn A', $contract->customer_name);
        $this->assertSame('1995-06-15', $contract->dob?->toDateString());
        $this->assertSame('Nam', $contract->gender);
        $this->assertStringStartsWith('HD-', $contract->contract_code);
        $this->assertSame($car->id, $contract->car_id);
        $this->assertSame(5, $contract->car_seats);
        $this->assertSame('47A-123.45', $contract->car_plate);
        $this->assertSame('Tự động', $contract->car_transmission);
        $this->assertSame('Máy xăng', $contract->car_fuel);
        $this->assertTrue($contract->contract_date?->isToday());
        $this->assertSame(7, $contract->images()->count());
        $this->assertSame(1, $contract->images()->where('category', 'cccd_front')->count());
        $this->assertSame(1, $contract->images()->where('category', 'cccd_back')->count());
        $this->assertSame(2, $contract->images()->where('category', 'car_video')->count());

        Storage::disk('public')->assertExists(str_replace('storage/', '', $contract->images()->where('category', 'cccd_front')->first()->path));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $contract->images()->where('category', 'cccd_back')->first()->path));
        Storage::disk('public')->assertExists(str_replace('storage/', '', $contract->images()->where('category', 'car_video')->first()->path));
    }

    public function test_admin_can_view_show_page(): void
    {
        Storage::fake('public');
        $contract = Contract::factory()->create([
            'customer_name' => 'Nguyễn Văn B',
            'status' => 'active',
            'total_rental_fee' => 6000000,
        ]);
        $contract->images()->create(['category' => 'cccd', 'path' => 'storage/contracts/cccd/x.jpg', 'sort_order' => 0]);

        $this->actingAs($this->admin())
            ->get(route('admin.contracts.show', $contract))
            ->assertOk()
            ->assertSee('Nguyễn Văn B')
            ->assertSee('x.jpg')
            ->assertSee('6.000.000đ');
    }

    public function test_admin_show_page_has_lookup_link_copy_button(): void
    {
        Storage::fake('public');
        $contract = Contract::factory()->create();

        $link = route('contract.lookup.shared', ['contract' => $contract->contract_code]);

        $this->actingAs($this->admin())
            ->get(route('admin.contracts.show', $contract))
            ->assertOk()
            ->assertSee('Sao chép link tra cứu')
            ->assertSee($link, false);
    }

    public function test_admin_index_page_has_lookup_link_copy_button(): void
    {
        Storage::fake('public');
        $contract = Contract::factory()->create();

        $link = route('contract.lookup.shared', ['contract' => $contract->contract_code]);

        $this->actingAs($this->admin())
            ->get(route('admin.contracts.index'))
            ->assertOk()
            ->assertSee($link, false);
    }

    public function test_admin_can_update_contract_and_delete_image(): void
    {
        Storage::fake('public');
        $contract = Contract::factory()->create(['customer_name' => 'Cũ']);
        $old = $contract->images()->create(['category' => 'cccd_front', 'path' => 'storage/contracts/cccd_front/old.jpg', 'sort_order' => 0]);
        $originalContractDate = $contract->contract_date;

        $payload = $this->contractPayload();
        $payload['customer_name'] = 'Mới';
        $payload['delete_images'] = [$old->id];
        $payload['images_car_video'][] = $this->uploadedVideo();

        $this->actingAs($this->admin())
            ->put(route('admin.contracts.update', $contract), $payload)
            ->assertRedirect();

        $contract->refresh();
        $this->assertSame('Mới', $contract->customer_name);
        $this->assertSame(1, $contract->images()->count());
        $this->assertSame('car_video', $contract->images()->first()->category);
        $this->assertEquals($originalContractDate, $contract->contract_date);

        Storage::disk('public')->assertMissing(str_replace('storage/', '', $old->path));
    }

    public function test_admin_can_destroy_contract_and_images(): void
    {
        Storage::fake('public');
        $contract = Contract::factory()->create();
        $contract->images()->create(['category' => 'cccd_front', 'path' => 'storage/contracts/cccd_front/del.jpg', 'sort_order' => 0]);

        $this->actingAs($this->admin())
            ->delete(route('admin.contracts.destroy', $contract))
            ->assertRedirect(route('admin.contracts.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('contracts', ['id' => $contract->id]);
        $this->assertDatabaseMissing('contract_images', ['contract_id' => $contract->id]);
    }
}