<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    protected $model = Server::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word . '-server',
            'ip_address' => $this->faker->unique()->ipv4(),
            'provider' => $this->faker->randomElement(['aws', 'digitalocean', 'vultr', 'other']),
            'status' => $this->faker->randomElement(['active', 'inactive', 'maintenance']),
            'cpu_cores' => $this->faker->numberBetween(1, 128),
            'ram_mb' => $this->faker->numberBetween(512, 1048576),
            'storage_gb' => $this->faker->numberBetween(10, 1048576),
            'version' => 0,
        ];
    }
}
