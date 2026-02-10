<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Polyclinic::create([
            'name' => 'Poli Umum',
        ]);

        Polyclinic::create([
            'name' => 'Poli Anak',
        ]);

        Polyclinic::create([
            'name' => 'Poli Gigi',
        ]);

        Polyclinic::create([
            'name' => 'Poli Kandungan',
        ]);

        Polyclinic::create([
            'name' => 'Poli Bedah',
        ]);

        Polyclinic::create([
            'name' => 'Poli Jantung',
        ]);

        Polyclinic::create([
            'name' => 'Poli Mata',
        ]);

        Polyclinic::create([
            'name' => 'Poli THT',
        ]);

        Polyclinic::create([
            'name' => 'Poli Kulit & Kelamin',
        ]);

        Polyclinic::create([
            'name' => 'Poli Paru',
        ]);
    }
}
