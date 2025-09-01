<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user with proper role first
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Run seeders that create roles and basic data
        $this->call([
            DefaultDataSeeder::class,
        ]);

        // Assign admin role after roles are created
        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $adminRole = \Spatie\Permission\Models\Role::where('name', 'Store Administrator')->first();
            if ($adminRole) {
                $adminUser->assignRole($adminRole);
            }
        }

        // Now run the dashboard seeder
        $this->call([
            DashboardDataSeeder::class,
        ]);
    }
}
