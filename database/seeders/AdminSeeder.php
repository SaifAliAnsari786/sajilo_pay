<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminArray = [
            'email' => 'admin@admin.com',
            'password' => \Hash::make('password'),
            'created_at' => \Carbon\Carbon::now()
        ];
        $userId = User::insert($adminArray);
        if (!empty($userId)) {
            \DB::table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => 1,
                'created_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
