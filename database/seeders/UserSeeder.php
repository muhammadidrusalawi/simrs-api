<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'name' => 'Admin SIMRS',
            'email' => 'admin@simrs.com',
            'role' => 'admin',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Nurse Joko',
            'email' => 'nurse.joko@simrs.com',
            'role' => 'nurse',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Cashier Rina',
            'email' => 'cashier.rina@simrs.com',
            'role' => 'cashier',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'id' => Str::uuid(),
            'name' => 'Budi',
            'email' => 'budi@simrs.com',
            'role' => 'patient',
            'password' => Hash::make('12345678'),
        ]);
    }
}
