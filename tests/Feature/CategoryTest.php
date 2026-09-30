<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_categories_page(): void
    {
        $response = $this->get(route('categories.index'));
        $response->assertStatus(200);
        $response->assertSee('Categories');
    }

    public function test_user_can_create_category(): void
    {
        $response = $this->post(route('categories.store'), [
            'name' => 'New Category',
            'description' => 'A new category description',
        ]);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category created successfully.');
        $this->assertDatabaseHas('categories', ['name' => 'New Category']);
    }

    public function test_category_creation_requires_name(): void
    {
        $response = $this->post(route('categories.store'), [
            'name' => '',
            'description' => 'Description',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_category_name_must_be_unique(): void
    {
        Category::factory()->create(['name' => 'Existing Category']);

        $response = $this->post(route('categories.store'), [
            'name' => 'Existing Category',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_can_edit_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->get(route('categories.edit', $category));
        $response->assertStatus(200);
        $response->assertSee($category->name);
    }

    public function test_user_can_update_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->put(route('categories.update', $category), [
            'name' => 'Updated Category',
            'description' => 'Updated description',
        ]);

        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category updated successfully.');
        $this->assertDatabaseHas('categories', ['name' => 'Updated Category']);
    }

    public function test_user_can_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete(route('categories.destroy', $category));
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('success', 'Category deleted successfully.');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_cannot_delete_category_with_projects(): void
    {
        $category = Category::factory()->create();
        $project = \App\Models\Project::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('categories.destroy', $category));
        $response->assertRedirect(route('categories.index'));
        $response->assertSessionHas('error');
    }
}
