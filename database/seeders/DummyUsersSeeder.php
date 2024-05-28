<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Nira Sari',
                'email' => 'admin@gmail.com',
                'role' => 'owner',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'karyawan1',
                'email' => 'employee@gmail.com',
                'role' => 'employee',
                'password' => bcrypt('12341234')
            ]
        ];

        foreach ($userData as $key => $value) {
            User::create($value);
        }

        \App\Models\User::factory(10)->create();
    }
}
