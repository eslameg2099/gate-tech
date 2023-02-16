<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApartmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Apartment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(1, 40),
            'floor' => $this->faker->numberBetween(1, 20),
            'building_id' => Building::factory(),
        ];
    }
}
