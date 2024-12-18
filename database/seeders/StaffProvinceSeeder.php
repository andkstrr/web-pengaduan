<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StaffProvince;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'jabar',
            'jatim',
            'jateng'
        ];

        foreach ($provinces as $province) {
            $user = User::firstOrCreate(
                ['email' => 'head_staff_' . $province . '@gmail.com'],
                [
                    'role' => 'head_staff',
                    'password' => Hash::make('tes123')
                ]
            );

            StaffProvince::create([
                'user_id' => $user->id,
                'province' => $province
            ]);
        }
    }   
}
