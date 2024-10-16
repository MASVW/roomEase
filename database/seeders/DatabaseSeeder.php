<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Request;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        User::factory()->count(10)->create();

        $this->call([
            RolePermissionSeeder::class,
            RoomSeeder::class,
            RequestRoomSeeder::class
        ]);

        Calendar::factory()->count(20)->create();
    }
}
