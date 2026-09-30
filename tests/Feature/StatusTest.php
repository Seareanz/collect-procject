<?php

namespace Tests\Feature;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_statuses_page(): void
    {
        $response = $this->get(route('statuses.index'));
        $response->assertStatus(200);
        $response->assertSee('Statuses');
    }

    public function test_user_can_create_status(): void
    {
        $response = $this->post(route('statuses.store'), [
            'name' => 'New Status',
        ]);

        $response->assertRedirect(route('statuses.index'));
        $response->assertSessionHas('success', 'Status created successfully.');
        $this->assertDatabaseHas('statuses', ['name' => 'New Status']);
    }

    public function test_status_creation_requires_name(): void
    {
        $response = $this->post(route('statuses.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_update_status(): void
    {
        $status = Status::factory()->create();

        $response = $this->put(route('statuses.update', $status), [
            'name' => 'Updated Status',
        ]);

        $response->assertRedirect(route('statuses.index'));
        $response->assertSessionHas('success', 'Status updated successfully.');
        $this->assertDatabaseHas('statuses', ['name' => 'Updated Status']);
    }

    public function test_user_can_delete_status(): void
    {
        $status = Status::factory()->create();

        $response = $this->delete(route('statuses.destroy', $status));
        $response->assertRedirect(route('statuses.index'));
        $response->assertSessionHas('success', 'Status deleted successfully.');
        $this->assertDatabaseMissing('statuses', ['id' => $status->id]);
    }
}
