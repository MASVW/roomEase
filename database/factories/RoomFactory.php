<?php

namespace Database\Factories;

use Faker\Provider\en_US\Text;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'AD101',
            'location' => 'AD',
            'capacity' => rand(30, 50),
            'facilities' => Text::randomLetter(100)
        ];
    }
}
