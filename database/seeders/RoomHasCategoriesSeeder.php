<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomCategories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomHasCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rooms = Room::all();
        $categories = RoomCategories::all();

        // Track inserted combinations to avoid duplicates
        $roomCategoryCombinations = [];

        // Ensure at least 80 unique combinations
        while (count($roomCategoryCombinations) < 80) {
            foreach ($rooms as $room) {
                // Randomly select between 1 and 3 categories for each room
                $selectedCategories = $categories->random(rand(1, 3));

                foreach ($selectedCategories as $category) {
                    $combinationKey = $room->id . '-' . $category->id;

                    // Check if the combination already exists
                    if (!isset($roomCategoryCombinations[$combinationKey])) {
                        DB::table('room_has_category')->insert([
                            'room_id' => $room->id,
                            'room_category_id' => $category->id,
                        ]);

                        // Track this combination to avoid duplicates
                        $roomCategoryCombinations[$combinationKey] = true;

                        // Break out if we reach 80 unique combinations
                        if (count($roomCategoryCombinations) >= 80) {
                            break 2;
                        }
                    }
                }
            }
        }
    }
}
