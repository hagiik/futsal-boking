<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Lapangan Futsal'],
            ['name' => 'Lapangan Badminton'],
            ['name' => 'Lapangan Mini Soccer'],
            ['name' => 'Lapangan Basket'],
        ];

        Category::factory()
            ->sequence(...$categories)
            ->create();
    }
}
