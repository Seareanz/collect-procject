<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);
        $startDate = fake()->dateTimeBetween('-2 years', 'now');
        $endDate = fake()->optional(0.7)->dateTimeBetween($startDate, '+1 year');

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(3),
            'thumbnail' => null,
            'category_id' => Category::factory(),
            'status_id' => Status::factory(),
            'role' => fake()->randomElement(['Developer', 'Lead Developer', 'Full Stack Developer', 'Backend Developer', 'Frontend Developer']),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'github_url' => fake()->optional(0.6)->url(),
            'demo_url' => fake()->optional(0.4)->url(),
            'notes' => fake()->optional(0.5)->paragraph(),
        ];
    }
}
