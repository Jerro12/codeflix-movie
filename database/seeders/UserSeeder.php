<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    private array $firstNames = [
        'James', 'Robert', 'John', 'Michael', 'David', 'William', 'Richard', 'Joseph',
        'Thomas', 'Christopher', 'Charles', 'Daniel', 'Matthew', 'Anthony', 'Mark',
        'Donald', 'Steven', 'Paul', 'Andrew', 'Joshua', 'Kenneth', 'Kevin', 'Brian',
        'Mary', 'Patricia', 'Jennifer', 'Linda', 'Elizabeth', 'Barbara', 'Susan',
        'Jessica', 'Sarah', 'Karen', 'Lisa', 'Nancy', 'Betty', 'Margaret', 'Sandra',
        'Ashley', 'Kimberly', 'Emily', 'Donna', 'Michelle', 'Dorothy', 'Carol',
        'Amanda', 'Melissa', 'Deborah', 'Stephanie', 'Rebecca', 'Sharon', 'Laura',
    ];

    private array $lastNames = [
        'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis',
        'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson',
        'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Perez', 'Thompson',
        'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson',
        'Walker', 'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen',
        'Hill', 'Flores', 'Green', 'Adams', 'Nelson', 'Baker', 'Hall', 'Rivera',
    ];

    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@codeflix.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@codeflix.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'referral_code' => 'ADMIN2024',
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $admin->id, 'name' => 'Admin'],
            [
                'name' => 'Admin',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Admin',
                'is_kids' => false,
            ]
        );

        // Create Main Test User
        $testUser = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'John Doe',
                'email' => 'test@example.com',
                'password' => Hash::make('Password123'),
                'is_admin' => false,
                'referral_code' => strtoupper(Str::random(8)),
                'email_verified_at' => now(),
            ]
        );

        Profile::updateOrCreate(
            ['user_id' => $testUser->id, 'name' => 'John'],
            ['name' => 'John', 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=John', 'is_kids' => false]
        );
        Profile::updateOrCreate(
            ['user_id' => $testUser->id, 'name' => 'Kids'],
            ['name' => 'Kids', 'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=Kids&backgroundColor=b6e3f4', 'is_kids' => true]
        );

        // Generate 50+ Demo Users
        $usedEmails = ['admin@codeflix.com', 'test@example.com'];
        
        for ($i = 0; $i < 55; $i++) {
            $firstName = $this->firstNames[array_rand($this->firstNames)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];
            $fullName = "{$firstName} {$lastName}";
            
            // Generate unique email
            $baseEmail = strtolower($firstName) . '.' . strtolower($lastName);
            $email = $baseEmail . '@example.com';
            $counter = 1;
            while (in_array($email, $usedEmails)) {
                $email = $baseEmail . $counter . '@example.com';
                $counter++;
            }
            $usedEmails[] = $email;

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                    'is_admin' => false,
                    'referral_code' => strtoupper(Str::random(8)),
                    'email_verified_at' => now(),
                ]
            );

            // Create main profile
            Profile::updateOrCreate(
                ['user_id' => $user->id, 'name' => $firstName],
                [
                    'name' => $firstName,
                    'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . urlencode($fullName),
                    'is_kids' => false,
                ]
            );

            // Some users get kids profile
            if (rand(0, 2) === 0) {
                Profile::updateOrCreate(
                    ['user_id' => $user->id, 'name' => 'Kids'],
                    [
                        'name' => 'Kids',
                        'avatar' => 'https://api.dicebear.com/7.x/lorelei/svg?seed=' . $firstName . 'Kids',
                        'is_kids' => true,
                    ]
                );
            }

            // Some users get additional profile
            if (rand(0, 3) === 0) {
                $secondName = $this->firstNames[array_rand($this->firstNames)];
                Profile::updateOrCreate(
                    ['user_id' => $user->id, 'name' => $secondName],
                    [
                        'name' => $secondName,
                        'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $secondName . $i,
                        'is_kids' => false,
                    ]
                );
            }
        }
    }
}
