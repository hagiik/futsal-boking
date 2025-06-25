<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = Field::all();
        
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($fields as $field) {
            foreach ($daysOfWeek as $day) {
                FieldSchedule::factory()
                    ->count(fake()->numberBetween(2, 3))
                    ->create([
                        'field_id' => $field->id,
                        'day_of_week' => $day,
                    ]);
            }
        }
    }
}
