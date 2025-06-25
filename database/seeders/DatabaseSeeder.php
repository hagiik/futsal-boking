<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
    {
        User::factory()->create([
            'name' => 'admin User',
            'email' => 'admin@example.com',
            'phone' => '081200001111',
            'password' => Hash::make('12345678'),
        ]);

        User::factory(10)->create();
        
        $this->call([
            CategorySeeder::class,
            FieldSeeder::class,
            FieldScheduleSeeder::class,
            MembershipSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
