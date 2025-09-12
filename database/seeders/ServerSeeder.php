<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    public function run()
    {
        $servers = [
            [
                'name' => 'web-server-1',
                'ip_address' => '192.168.1.10',
                'provider' => 'aws',
                'status' => 'active',
                'cpu_cores' => 4,
                'ram_mb' => 8192,
                'storage_gb' => 100,
            ],
            [
                'name' => 'db-server-1',
                'ip_address' => '192.168.1.20',
                'provider' => 'digitalocean',
                'status' => 'active',
                'cpu_cores' => 8,
                'ram_mb' => 16384,
                'storage_gb' => 500,
            ],
            [
                'name' => 'app-server-1',
                'ip_address' => '192.168.1.30',
                'provider' => 'vultr',
                'status' => 'maintenance',
                'cpu_cores' => 2,
                'ram_mb' => 4096,
                'storage_gb' => 50,
            ],
            [
                'name' => 'backup-server-1',
                'ip_address' => '192.168.1.40',
                'provider' => 'other',
                'status' => 'inactive',
                'cpu_cores' => 1,
                'ram_mb' => 1024,
                'storage_gb' => 1000,
            ],
        ];

        foreach ($servers as $server) {
            Server::create($server);
        }

        // Create additional servers for testing pagination
        for ($i = 2; $i <= 15; $i++) {
            Server::create([
                'name' => 'test-server-' . $i,
                'ip_address' => '192.168.1.' . (40 + $i),
                'provider' => ['aws', 'digitalocean', 'vultr', 'other'][array_rand([0, 1, 2, 3])],
                'status' => ['active', 'inactive', 'maintenance'][array_rand([0, 1, 2])],
                'cpu_cores' => rand(1, 16),
                'ram_mb' => rand(1024, 16384),
                'storage_gb' => rand(50, 1000),
            ]);
        }
    }
}
