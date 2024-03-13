<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $roleArray = [
                [
                    'name' => 'admin',
                    'created_at' => \Carbon\Carbon::now()
                ],
                [
                    'name' => 'hr',
                    'created_at' => \Carbon\Carbon::now()
                ],
                [
                    'name' => 'employee',
                    'created_at' => \Carbon\Carbon::now()
                ]
            ];
            \DB::table('roles')->insert($roleArray);
        }
    }
}
