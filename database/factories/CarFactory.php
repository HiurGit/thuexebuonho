<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company() . ' ' . fake()->randomElement(['Vios', 'City', 'Accent', 'Morning']),
            'slug' => fake()->unique()->slug(),
            'plate' => '47A-' . fake()->numerify('#####') . '.' . fake()->numerify('##'),
            'description' => fake()->sentence(),
            'seats' => 5,
            'transmission' => 'Tự động',
            'fuel' => 'Máy xăng',
            'year' => fake()->numberBetween(2015, 2024),
            'insurance' => 'Đầy đủ',
            'address' => '07 Chu Văn An, Buôn Hồ',
            'price_per_day' => 700000,
            'price_per_session' => 350000,
            'price_multi_day' => null,
            'price_out_province' => null,
            'deposit_min' => 300000,
            'deposit_max' => 1000000,
            'deposit_asset' => 15000000,
            'status' => 'available',
            'sort_order' => 0,
        ];
    }
}