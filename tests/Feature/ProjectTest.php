<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\Status;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_user_can_view_projects_page(): void
    {
        $response = $this->get(route('projects.index'));
        $response->assertStatus(200);
        $response->assertSee('All Projects');
    }

    public function test_user_can_create_project(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $tech = Technology::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => 'Test Project',
            'description' => 'This is a test project description.',
            'category_id' => $category->id,
            'status_id' => $status->id,
            'role' => 'Developer',
            'start_date' => '2024-01-01',
            'end_date' => '2024-12-31',
            'technologies' => [$tech->id],
            'features' => [
                ['name' => 'Feature 1', 'description' => 'Description 1'],
            ],
        ]);

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'Project created successfully.');
        $this->assertDatabaseHas('projects', ['title' => 'Test Project']);
        $this->assertDatabaseHas('features', ['name' => 'Feature 1']);
    }

    public function test_project_creation_requires_title(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => '',
            'description' => 'Description',
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_project_creation_requires_description(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => 'Test Project',
            'description' => '',
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $response->assertSessionHasErrors('description');
    }

    public function test_project_creation_requires_valid_category(): void
    {
        $status = Status::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => 'Test Project',
            'description' => 'Description',
            'category_id' => 9999,
            'status_id' => $status->id,
        ]);

        $response->assertSessionHasErrors('category_id');
    }

    public function test_project_creation_requires_valid_status(): void
    {
        $category = Category::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => 'Test Project',
            'description' => 'Description',
            'category_id' => $category->id,
            'status_id' => 9999,
        ]);

        $response->assertSessionHasErrors('status_id');
    }

    public function test_end_date_must_be_after_start_date(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();

        $response = $this->post(route('projects.store'), [
            'title' => 'Test Project',
            'description' => 'Description',
            'category_id' => $category->id,
            'status_id' => $status->id,
            'start_date' => '2024-12-31',
            'end_date' => '2024-01-01',
        ]);

        $response->assertSessionHasErrors('end_date');
    }

    public function test_user_can_view_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.show', $project));
        $response->assertStatus(200);
        $response->assertSee($project->title);
    }

    public function test_user_can_edit_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.edit', $project));
        $response->assertStatus(200);
        $response->assertSee($project->title);
    }

    public function test_user_can_update_project(): void
    {
        $project = Project::factory()->create();
        $newCategory = Category::factory()->create();
        $newStatus = Status::factory()->create();

        $response = $this->put(route('projects.update', $project), [
            'title' => 'Updated Project',
            'description' => 'Updated description',
            'category_id' => $newCategory->id,
            'status_id' => $newStatus->id,
        ]);

        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'Project updated successfully.');
        $this->assertDatabaseHas('projects', ['title' => 'Updated Project']);
    }

    public function test_user_can_delete_project(): void
    {
        $project = Project::factory()->create();

        $response = $this->delete(route('projects.destroy', $project));
        $response->assertRedirect(route('projects.index'));
        $response->assertSessionHas('success', 'Project deleted successfully.');
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_project_deletion_removes_features(): void
    {
        $project = Project::factory()->create();
        $project->features()->create(['name' => 'Test Feature']);

        $this->delete(route('projects.destroy', $project));

        $this->assertDatabaseMissing('features', ['project_id' => $project->id]);
    }

    public function test_project_deletion_detaches_technologies(): void
    {
        $project = Project::factory()->create();
        $tech = Technology::factory()->create();
        $project->technologies()->attach($tech->id);

        $this->delete(route('projects.destroy', $project));

        $this->assertDatabaseMissing('project_technology', ['project_id' => $project->id]);
    }

    public function test_user_can_upload_thumbnail(): void
    {
        Storage::fake('public');
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $file = UploadedFile::fake()->image('thumbnail.jpg');

        $response = $this->post(route('projects.store'), [
            'title' => 'Project with Thumbnail',
            'description' => 'Description',
            'category_id' => $category->id,
            'status_id' => $status->id,
            'thumbnail' => $file,
        ]);

        $response->assertRedirect(route('projects.index'));
        Storage::disk('public')->assertExists('projects/' . $file->hashName());
    }

    public function test_search_filters_projects_by_title(): void
    {
        Project::factory()->create(['title' => 'Laravel Project']);
        Project::factory()->create(['title' => 'React Project']);

        $response = $this->get(route('projects.index', ['search' => 'Laravel']));
        $response->assertStatus(200);
        $response->assertSee('Laravel Project');
        $response->assertDontSee('React Project');
    }

    public function test_filter_by_category(): void
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        Project::factory()->create(['category_id' => $category1->id, 'title' => 'Cat1 Project']);
        Project::factory()->create(['category_id' => $category2->id, 'title' => 'Cat2 Project']);

        $response = $this->get(route('projects.index', ['category' => $category1->id]));
        $response->assertStatus(200);
        $response->assertSee('Cat1 Project');
        $response->assertDontSee('Cat2 Project');
    }

    public function test_filter_by_status(): void
    {
        $status1 = Status::factory()->create();
        $status2 = Status::factory()->create();
        Project::factory()->create(['status_id' => $status1->id, 'title' => 'Status1 Project']);
        Project::factory()->create(['status_id' => $status2->id, 'title' => 'Status2 Project']);

        $response = $this->get(route('projects.index', ['status' => $status1->id]));
        $response->assertStatus(200);
        $response->assertSee('Status1 Project');
        $response->assertDontSee('Status2 Project');
    }

    public function test_filter_by_technology(): void
    {
        $tech1 = Technology::factory()->create();
        $tech2 = Technology::factory()->create();
        $project1 = Project::factory()->create(['title' => 'Tech1 Project']);
        $project1->technologies()->attach($tech1->id);
        $project2 = Project::factory()->create(['title' => 'Tech2 Project']);
        $project2->technologies()->attach($tech2->id);

        $response = $this->get(route('projects.index', ['technology' => $tech1->id]));
        $response->assertStatus(200);
        $response->assertSee('Tech1 Project');
        $response->assertDontSee('Tech2 Project');
    }

    public function test_combined_filters(): void
    {
        $category = Category::factory()->create();
        $status = Status::factory()->create();
        $tech = Technology::factory()->create();

        $project1 = Project::factory()->create([
            'title' => 'Matching Project',
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);
        $project1->technologies()->attach($tech->id);

        $project2 = Project::factory()->create([
            'title' => 'Non-Matching Project',
            'category_id' => $category->id,
            'status_id' => $status->id,
        ]);

        $response = $this->get(route('projects.index', [
            'category' => $category->id,
            'status' => $status->id,
            'technology' => $tech->id,
        ]));
        $response->assertStatus(200);
        $response->assertSee('Matching Project');
        $response->assertDontSee('Non-Matching Project');
    }

    public function test_pagination_works(): void
    {
        Project::factory()->count(15)->create();

        $response = $this->get(route('projects.index'));
        $response->assertStatus(200);
        // Check that pagination nav exists
        $response->assertSee('Pagination Navigation');
    }

    public function test_guest_cannot_access_projects(): void
    {
        $this->post(route('logout'));
        $response = $this->get(route('projects.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_create_project(): void
    {
        $this->post(route('logout'));
        $response = $this->get(route('projects.create'));
        $response->assertRedirect(route('login'));
    }
}
