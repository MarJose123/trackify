<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProjectsFactory extends Factory
{
    protected $model = Projects::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'status' => $this->faker->randomElement(Status::cases())->value,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::first(),
            'clients_id' => Clients::inRandomOrder()->first(),
        ];
    }
}
