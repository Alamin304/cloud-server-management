<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        // Create a user and authenticate
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/');

        // Should redirect to servers index
        $response->assertRedirect(route('servers.index'));
    }
}
