<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => '管理者',
            'email' => config('app.admin.email'),
            'password' => Hash::make(config('app.admin.password')),
            'email_verified_at' => now(),
        ]);
    }
}
