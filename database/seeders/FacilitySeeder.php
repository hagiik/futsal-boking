<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['name' => 'Ruang Ganti', 'icon' => 'shirt'],
            ['name' => 'Kamar Mandi', 'icon' => 'bath'],
            ['name' => 'Parkiran Luas', 'icon' => 'parking-circle'],
            ['name' => 'Kantin', 'icon' => 'sandwich'],
            ['name' => 'Wifi Gratis', 'icon' => 'wifi'],
            ['name' => 'Penerangan Malam', 'icon' => 'lightbulb'],
            ['name' => 'Musala', 'icon' => 'mosque'],
            ['name' => 'Lemari Loker', 'icon' => 'locker'],
            ['name' => 'Lapangan Indoor', 'icon' => 'warehouse'],
            ['name' => 'Wasit Profesional', 'icon' => 'whistle'],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
