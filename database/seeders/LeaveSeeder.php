<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("leave_types")->insert([
            [
                'name' => 'Festival',
                'days' => 9,
                'created_at' => \Carbon\Carbon::now()
            ],[
                'name' => 'Sick',
                'days' => 17,
                'created_at' => \Carbon\Carbon::now()
            ],[
                'name' => 'Unpaid',
                'days' => 12,
                'created_at' => \Carbon\Carbon::now()
            ]
        ]);
    }
}
