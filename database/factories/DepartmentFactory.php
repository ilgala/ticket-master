<?php

namespace Database\Factories;

use App\Enums\DepartmentCodes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(5),
            'code' => fake()->randomElement(DepartmentCodes::cases()),
        ];
    }

    public function admin(): DepartmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => DepartmentCodes::ADMIN,
            ];
        });
    }

    public function comm(): DepartmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => DepartmentCodes::COMM,
            ];
        });
    }

    public function tech(): DepartmentFactory|Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'code' => DepartmentCodes::TECH,
            ];
        });
    }
}
