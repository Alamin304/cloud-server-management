<?php

namespace Tests\Feature;

use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_view_servers_index()
    {
        Server::factory()->count(5)->create();

        $response = $this->get(route('servers.index'));

        $response->assertStatus(200);
        $response->assertSee('Server Management');
    }

    public function test_can_create_server()
    {
        $serverData = [
            'name' => 'test-server',
            'ip_address' => '192.168.1.100',
            'provider' => 'aws',
            'status' => 'active',
            'cpu_cores' => 4,
            'ram_mb' => 8192,
            'storage_gb' => 100,
            'version' => 0, // Add version field
        ];

        $response = $this->post(route('servers.store'), $serverData);

        $response->assertRedirect(route('servers.index'));
        $this->assertDatabaseHas('servers', $serverData);
    }

    public function test_cannot_create_server_with_duplicate_ip()
    {
        $server = Server::factory()->create(['ip_address' => '192.168.1.100']);

        $serverData = [
            'name' => 'another-server',
            'ip_address' => '192.168.1.100', // Same IP
            'provider' => 'digitalocean',
            'status' => 'active',
            'cpu_cores' => 2,
            'ram_mb' => 4096,
            'storage_gb' => 50,
            'version' => 0, // Add version field
        ];

        $response = $this->post(route('servers.store'), $serverData);

        $response->assertSessionHasErrors('ip_address');
        $this->assertDatabaseCount('servers', 1);
    }

    public function test_can_update_server()
    {
        $server = Server::factory()->create();

        $updateData = [
            'name' => 'updated-server',
            'ip_address' => $server->ip_address,
            'provider' => $server->provider,
            'status' => 'inactive',
            'cpu_cores' => 8,
            'ram_mb' => 16384,
            'storage_gb' => 200,
            'version' => $server->version, // Include current version
        ];

        $response = $this->put(route('servers.update', $server), $updateData);

        $response->assertRedirect(route('servers.index'));
        $this->assertDatabaseHas('servers', array_merge(['id' => $server->id], $updateData));
    }

    public function test_can_delete_server()
    {
        $server = Server::factory()->create();

        $response = $this->delete(route('servers.destroy', $server));

        $response->assertRedirect(route('servers.index'));
        $this->assertDatabaseMissing('servers', ['id' => $server->id]);
    }

    public function test_api_can_list_servers()
    {
        Server::factory()->count(3)->create();

        $response = $this->getJson('/api/servers');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }
}
