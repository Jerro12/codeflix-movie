<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
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
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Codeflix',
            'email' => 'admin@codeflix.local',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'referral_code' => strtoupper(Str::random(8)),
        ]);

        // Create default profile for admin
        Profile::create([
            'user_id' => $admin->id,
            'name' => 'Admin',
            'is_kids' => false,
        ]);

        // Create Test User
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@codeflix.local',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'referral_code' => strtoupper(Str::random(8)),
        ]);

        // Create profiles for test user
        Profile::create([
            'user_id' => $user->id,
            'name' => 'Test User',
            'is_kids' => false,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'name' => 'Kids',
            'is_kids' => true,
        ]);

        $this->command->info('✅ Users created:');
        $this->command->info('   Admin: admin@codeflix.local / password');
        $this->command->info('   User:  user@codeflix.local / password');
    }
}
