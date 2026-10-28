<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        return [
            'contract_code' => 'HD-' . fake()->unique()->numerify('#########'),
            'status' => fake()->randomElement(['pending', 'active', 'returned', 'cancelled']),
            'contract_date' => now(),
            'cccd' => fake()->numerify('############'),
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->numerify('09########'),
            'cccd_issue_date' => now()->subYears(5),
            'cccd_issue_place' => 'Đắk Lắk',
            'customer_address' => fake()->address(),
            'driver_license_no' => fake()->bothify('B2-#######'),
            'license_issue_date' => now()->subYears(3),
            'license_expiry_date' => now()->addYears(7),
            'license_class' => 'B2',
            'car_name' => 'Toyota Vios',
            'car_brand' => 'Toyota',
            'car_model' => 'Vios 1.5G',
            'car_plate' => '47A-' . fake()->numerify('#####') . '.' . fake()->numerify('##'),
            'car_color' => 'Trắng',
            'car_year' => 2020,
            'car_seats' => 5,
            'car_transmission' => 'Tự động',
            'car_fuel' => 'Máy xăng',
            'pickup_datetime' => now()->addDays(1),
            'pickup_location' => '07 Chu Văn An, Buôn Hồ',
            'return_datetime' => now()->addDays(3),
            'return_location' => '07 Chu Văn An, Buôn Hồ',
            'total_days' => 2,
            'total_hours' => 0,
            'km_limit' => 300,
            'deposit_type' => 'cash',
            'deposit_amount' => 2000000,
            'deposit_note' => null,
            'daily_rate' => 700000,
            'rental_days' => 2,
            'total_rental_fee' => 1400000,
            'notes' => null,
        ];
    }
}