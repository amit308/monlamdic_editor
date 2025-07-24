<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing admin user if exists
        User::where('email', 'admin@monlamdic.org')->forceDelete();
        
        // Create admin user with verified email and security settings
        User::create([
            'name' => 'Admin',
            'email' => 'admin@monlamdic.org',
            'password' => Hash::make('monlam2025'),
            'email_verified_at' => now(),
            // 'is_active' => true,
            'last_activity_at' => now(),
            // 'last_login_ip' => '127.0.0.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Ju_Tenkyong',
            'email' => 'tenkyong1973@gmail.com',
            'password' => Hash::make('MD1@123'),
            'email_verified_at' => now(),
            // 'is_active' => true,
            'last_activity_at' => now(),
            // 'last_login_ip' => '127.0.0.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Kan_Sangjee',
            'email' => 'thewosangjee@monlam.ai',
            'password' => Hash::make('MD2@123'),
            'email_verified_at' => now(),
            // 'is_active' => true,
            'last_activity_at' => now(),
            // 'last_login_ip' => '127.0.0.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'She_Gamtso',
            'email' => 'sherabgamtso@gmail.com',
            'password' => Hash::make('MD3@123'),
            'email_verified_at' => now(),
            // 'is_active' => true,
            'last_activity_at' => now(),
            // 'last_login_ip' => '127.0.0.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'name' => 'Jam_Tsultrim',
            'email' => 'jamtsul@monlam.ai',
            'password' => Hash::make('MD4@123'),
            'email_verified_at' => now(),
            // 'is_active' => true,
            'last_activity_at' => now(),
            // 'last_login_ip' => '127.0.0.1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $this->command->info('Admin user created successfully!');
        $this->command->warn('Please change the default admin password after first login!');
    }
}
