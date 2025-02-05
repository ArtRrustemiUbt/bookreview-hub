<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        if (!$adminRole) {
            $adminRole = Role::create(['name' => 'admin']);
        }

        if (!User::where('email', 'art@gmail.com')->exists()) {
            $user = User::create([
                'name' => 'Art',
                'email' => 'art@gmail.com',
                'password' => Hash::make('123123123'), 
            ]);

            $user->assignRole('admin');

            echo "Admin user 'Art' created successfully.\n";
        } else {
            echo "User with email 'art@gmail.com' already exists.\n";
        }
    }
}
