<?php

namespace Database\Seeders;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('id', '!=', 1)->get();

        foreach ($users as $user) {
            Membership::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
