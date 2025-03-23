<?php

namespace Database\Factories;

use App\Enums\BillingMethod;
use App\Models\Clients;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientsFactory extends Factory
{
    protected $model = Clients::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'currency' => $this->faker->currencyCode(),
            'billing_method' => $this->faker->randomElement(BillingMethod::cases())->value,
            'company_name' => $this->faker->company(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::first(),
        ];
    }
}
