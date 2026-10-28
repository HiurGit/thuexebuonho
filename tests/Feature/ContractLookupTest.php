<?php

namespace Tests\Feature;

use App\Models\Contract;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Tests\TestCase;

class ContractLookupTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // The project's migrations use MySQL-only syntax (MODIFY COLUMN ... ENUM),
        // so this suite only runs against a MySQL connection (phpunit.mysql.xml).
        if (Config::get('database.default') === 'sqlite') {
            $this->markTestSkipped('Skipped on SQLite: project migrations are MySQL-only.');
        }
    }

    private function contract(array $attributes = []): Contract
    {
        return Contract::factory()->create(array_merge([
            'contract_code' => 'HD-TEST-' . strtoupper(Str::random(10)),
            'customer_name' => 'Trần Thị B',
            'customer_phone' => '0912345678',
            'cccd' => '067123456789',
            'car_name' => 'Toyota Vios',
        ], $attributes));
    }

    public function test_lookup_page_renders_form(): void
    {
        $this->get(route('contract.lookup'))
            ->assertOk()
            ->assertSee('Tra cứu hợp đồng')
            ->assertSee('contract_code')
            ->assertSee('phone');
    }

    public function test_shared_link_renders_prefilled_lookup_form(): void
    {
        $contract = $this->contract();

        $url = route('contract.lookup.shared', ['contract' => $contract->contract_code]);

        $this->get($url)
            ->assertOk()
            ->assertSee($contract->contract_code)
            ->assertSee('phone')
            ->assertDontSee($contract->customer_name);
    }

    public function test_shared_link_rejects_unknown_code(): void
    {
        $this->get(route('contract.lookup.shared', ['contract' => 'HD-00000000-999']))
            ->assertNotFound();
    }

    public function test_customer_can_lookup_with_code_and_phone(): void
    {
        $contract = $this->contract();

        $this->post(route('contract.lookup.check'), [
            'contract_code' => $contract->contract_code,
            'phone' => '0912345678',
        ])
            ->assertOk()
            ->assertSee('Trần Thị B')
            ->assertSee('Toyota Vios')
            ->assertSee('067*****6789', false)
            ->assertSee('091****678', false)
            ->assertDontSee('name="phone"', false)
            ->assertDontSee('name="contract_code"', false)
            ->assertDontSee('067123456789')
            ->assertDontSee('0912345678');
    }

    public function test_lookup_is_case_insensitive_and_normalizes_phone(): void
    {
        $contract = $this->contract();

        $this->post(route('contract.lookup.check'), [
            'contract_code' => ' ' . strtolower($contract->contract_code) . ' ',
            'phone' => '091 234.5678',
        ])->assertOk()->assertSee('Trần Thị B');

        $this->post(route('contract.lookup.check'), [
            'contract_code' => $contract->contract_code,
            'phone' => '+84 912 345 678',
        ])->assertOk()->assertSee('Trần Thị B');
    }

    public function test_lookup_fails_with_wrong_phone(): void
    {
        $contract = $this->contract();

        $response = $this->from(route('contract.lookup'))->post(route('contract.lookup.check'), [
            'contract_code' => $contract->contract_code,
            'phone' => '0900000000',
        ]);

        $response->assertRedirect(route('contract.lookup'))
            ->assertSessionHasErrors('lookup');

        $this->get(route('contract.lookup'))
            ->assertOk()
            ->assertDontSee('Trần Thị B');
    }

    public function test_lookup_fails_with_unknown_code(): void
    {
        $this->contract();

        $this->from(route('contract.lookup'))->post(route('contract.lookup.check'), [
            'contract_code' => 'HD-00000000-999',
            'phone' => '0912345678',
        ])
            ->assertRedirect(route('contract.lookup'))
            ->assertSessionHasErrors('lookup');
    }

    public function test_lookup_only_shows_car_media(): void
    {
        $contract = $this->contract();
        $contract->images()->create(['category' => 'cccd_front', 'path' => 'storage/contracts/cccd_front/id.jpg', 'sort_order' => 0]);
        $contract->images()->create(['category' => 'car_before', 'path' => 'storage/contracts/car_before/car.jpg', 'sort_order' => 1]);

        $this->post(route('contract.lookup.check'), [
            'contract_code' => $contract->contract_code,
            'phone' => '0912345678',
        ])
            ->assertOk()
            ->assertSee('storage/contracts/car_before/car.jpg')
            ->assertDontSee('storage/contracts/cccd_front/id.jpg');
    }
}
