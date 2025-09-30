<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);

        $admin = User::firstOrCreate([
            'id' => 1,
        ], [
            'name' => 'Admin User',
            'email' => 'admin@myfarm.com',
        ]);
        $admin->password = Hash::make('password');
        $admin->save();

        $admin->assignRole($adminRole);
    }
}
