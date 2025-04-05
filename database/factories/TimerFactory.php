<?php

namespace Database\Factories;

use App\Models\Clients;
use App\Models\Projects;
use App\Models\Timer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TimerFactory extends Factory
{
    protected $model = Timer::class;

    public function definition(): array
    {
        return [
            'duration' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'timer' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'clients_id' => Clients::factory(),
            'projects_id' => Projects::factory(),
        ];
    }
}
