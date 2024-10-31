<?php

namespace Database\Seeders;

use App\Models\RoomCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $predefinedTypes = [
            'building' => 'Building Location',
            'floor' => 'Floor Level',
            'connection' => 'Connection Type',
            'style' => 'Room Style',
        ];

        $categories = [
            ['type' => $predefinedTypes['building'], 'name' => 'Aryaduta (AD)'],
            ['type' => $predefinedTypes['building'], 'name' => 'Lippo Plaza (LP)'],

            ['type' => $predefinedTypes['floor'], 'name' => '1st Floor (AD only)'],
            ['type' => $predefinedTypes['floor'], 'name' => '5th Floor (LP)'],
            ['type' => $predefinedTypes['floor'], 'name' => '6th Floor (LP)'],
            ['type' => $predefinedTypes['floor'], 'name' => '7th Floor (LP)'],

            ['type' => $predefinedTypes['connection'], 'name' => '2 Rooms Connection'],
            ['type' => $predefinedTypes['connection'], 'name' => '3 Rooms Connection'],
            ['type' => $predefinedTypes['connection'], 'name' => '4 Rooms Connection'],

            ['type' => $predefinedTypes['style'], 'name' => 'Harvard Style (LP only)'],
            ['type' => $predefinedTypes['style'], 'name' => 'Computer Laboratory (LP)'],
            ['type' => $predefinedTypes['style'], 'name' => 'Round Table (LP)'],
        ];

        foreach ($categories as $category) {
            RoomCategories::create($category);
        }
    }
}
