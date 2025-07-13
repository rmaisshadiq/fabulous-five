<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'system@internal.app'],
            [
                'name' => 'System',
                'password' => Hash::make(str()->random(30)),
            ]
        );

        Employee::firstOrCreate(
            ['user_id' => User::where('email', 'system@internal.app')->first()->id],
            [
                'position' => 'System',
                'hire_date' => now(),
                'status' => 'active',
                'phone' => '081234567890'
            ]
            );
    }
}
