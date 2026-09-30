<?php

namespace Tests\Feature;

use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TechnologyTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_technologies_page(): void
    {
        $response = $this->get(route('technologies.index'));
        $response->assertStatus(200);
        $response->assertSee('Technologies');
    }

    public function test_user_can_create_technology(): void
    {
        $response = $this->post(route('technologies.store'), [
            'name' => 'New Technology',
            'icon' => 'new-tech',
        ]);

        $response->assertRedirect(route('technologies.index'));
        $response->assertSessionHas('success', 'Technology created successfully.');
        $this->assertDatabaseHas('technologies', ['name' => 'New Technology']);
    }

    public function test_technology_creation_requires_name(): void
    {
        $response = $this->post(route('technologies.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_update_technology(): void
    {
        $technology = Technology::factory()->create();

        $response = $this->put(route('technologies.update', $technology), [
            'name' => 'Updated Technology',
        ]);

        $response->assertRedirect(route('technologies.index'));
        $response->assertSessionHas('success', 'Technology updated successfully.');
        $this->assertDatabaseHas('technologies', ['name' => 'Updated Technology']);
    }

    public function test_user_can_delete_technology(): void
    {
        $technology = Technology::factory()->create();

        $response = $this->delete(route('technologies.destroy', $technology));
        $response->assertRedirect(route('technologies.index'));
        $response->assertSessionHas('success', 'Technology deleted successfully.');
        $this->assertDatabaseMissing('technologies', ['id' => $technology->id]);
    }
}
