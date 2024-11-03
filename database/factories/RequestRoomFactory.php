<?php

namespace Database\Factories;

use App\Models\RequestRoom;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RequestRoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RequestRoom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Generate start and end dates
        $start = $this->faker->dateTimeBetween('+0 days', '+1 month');
        $end = (clone $start)->modify('+'. $this->faker->numberBetween(1, 8) .' hours');

        return [
            'title' => $this->faker->sentence(6, true),
            'description' => $this->faker->paragraph(3),
            'start' => $start,
            'end' => $end,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

    /**
     * Indicate that the request room is approved.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function approved()
    {
        return $this->state([
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the request room is rejected.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function rejected()
    {
        return $this->state([
            'status' => 'rejected',
        ]);
    }

    /**
     * Indicate that the request room is pending.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function pending()
    {
        return $this->state([
            'status' => 'pending',
        ]);
    }
}
