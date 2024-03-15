<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => fake()->text(500),
        ];
    }

    public function withMandatoryRelations(?Department $department = null): TicketFactory
    {
        return $this->for(User::factory()->create(), 'creator')
            ->for($department ?: Department::factory()->create(), 'department');
    }
}
