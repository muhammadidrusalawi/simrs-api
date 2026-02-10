<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            ['name' => 'Dr. Ani', 'email' => 'dr.ani@simrs.com', 'sip_number' => 'SIP001', 'specialization' => 'Umum'],
            ['name' => 'Dr. Budi', 'email' => 'dr.budi@simrs.com', 'sip_number' => 'SIP002', 'specialization' => 'Anak'],
            ['name' => 'Dr. Sari', 'email' => 'dr.sari@simrs.com', 'sip_number' => 'SIP003', 'specialization' => 'Gigi'],
            ['name' => 'Dr. Rudi', 'email' => 'dr.rudi@simrs.com', 'sip_number' => 'SIP004', 'specialization' => 'Kandungan'],
            ['name' => 'Dr. Maya', 'email' => 'dr.maya@simrs.com', 'sip_number' => 'SIP005', 'specialization' => 'Bedah'],
            ['name' => 'Dr. Fajar', 'email' => 'dr.fajar@simrs.com', 'sip_number' => 'SIP006', 'specialization' => 'Jantung'],
            ['name' => 'Dr. Lina', 'email' => 'dr.lina@simrs.com', 'sip_number' => 'SIP007', 'specialization' => 'Mata'],
            ['name' => 'Dr. Agus', 'email' => 'dr.agus@simrs.com', 'sip_number' => 'SIP008', 'specialization' => 'THT'],
            ['name' => 'Dr. Rina', 'email' => 'dr.rina@simrs.com', 'sip_number' => 'SIP009', 'specialization' => 'Kulit & Kelamin'],
            ['name' => 'Dr. Dedi', 'email' => 'dr.dedi@simrs.com', 'sip_number' => 'SIP010', 'specialization' => 'Paru'],
        ];

        foreach ($doctors as $doc) {
            $user = User::create([
                'id' => Str::uuid(),
                'name' => $doc['name'],
                'email' => $doc['email'],
                'role' => 'doctor',
                'password' => Hash::make('12345678'),
            ]);

            Doctor::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'name' => $doc['name'],
                'sip_number' => $doc['sip_number'],
                'specialization' => $doc['specialization'],
                'is_active' => true,
            ]);
        }
    }
}
