<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
    {
        $name = 'Arena ' . fake()->company();
        return [
            'field_category_id' => Category::inRandomOrder()->first()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(3),
            'image' => json_encode([
                'https://picsum.photos/seed/'.fake()->word().'/800/600',
                'https://picsum.photos/seed/'.fake()->word().'/800/600',
                'https://picsum.photos/seed/'.fake()->word().'/800/600',
            ]),
        ];
    }
}
