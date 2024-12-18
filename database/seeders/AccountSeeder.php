<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'staff@gmail.com',
            'password' => Hash::make('staff123'),
            'role' => 'STAFF'
        ]);

        User::create([
            'email' => 'head_staff@gmail.com',
            'password' => Hash::make('head123'),
            'role' => 'HEAD_STAFF'
        ]);

        // $provinces = [
        //     'jabar' => 'Jawa Barat',
        //     'jateng' => 'Jawa Tengah',
        //     'jatim' => 'Jawa Timur'
        // ];

        // foreach ($provinces as $key => $name) {
        //         User::create(
        //             ['email' => 'head_staff_' . $key . '@gmail.com'],
        //             [
        //                 'role' => 'HEAD_STAFF',
        //                 'password' => Hash::make('headstaff123')
        //             ]
        //     );
        // }
    }
}
