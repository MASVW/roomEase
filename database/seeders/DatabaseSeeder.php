<?php

namespace Database\Seeders;

use App\Models\Calendar;
use App\Models\Request;
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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->count(10)->create();

        $this->call([
            RoomSeeder::class,
            RequestRoomSeeder::class
        ]);

        Calendar::factory()->count(20)->create();
    }
}
