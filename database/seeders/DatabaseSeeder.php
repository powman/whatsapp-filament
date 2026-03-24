<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a demo tenant and admin user
        $tenant = Tenant::create([
            'name' => 'Demo Company',
            'slug' => 'demo-company',
            'plan' => 'free',
            'is_active' => true,
        ]);

        User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
