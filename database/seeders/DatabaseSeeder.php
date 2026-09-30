<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Feature;
use App\Models\Project;
use App\Models\Status;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default statuses
        $statuses = [
            ['name' => 'Planning', 'slug' => 'planning'],
            ['name' => 'In Progress', 'slug' => 'in-progress'],
            ['name' => 'Completed', 'slug' => 'completed'],
            ['name' => 'Archived', 'slug' => 'archived'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }

        // Create default categories
        $categories = [
            ['name' => 'Website', 'slug' => 'website', 'description' => 'Web-based applications and sites'],
            ['name' => 'Desktop App', 'slug' => 'desktop-app', 'description' => 'Desktop applications'],
            ['name' => 'Mobile App', 'slug' => 'mobile-app', 'description' => 'Mobile applications'],
            ['name' => 'API', 'slug' => 'api', 'description' => 'RESTful APIs and services'],
            ['name' => 'Bot', 'slug' => 'bot', 'description' => 'Chatbots and automation'],
            ['name' => 'Game', 'slug' => 'game', 'description' => 'Game development projects'],
            ['name' => 'Design', 'slug' => 'design', 'description' => 'UI/UX design projects'],
            ['name' => 'Other', 'slug' => 'other', 'description' => 'Other projects'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create default technologies
        $technologies = [
            ['name' => 'PHP', 'slug' => 'php', 'icon' => 'php'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'icon' => 'laravel'],
            ['name' => 'Python', 'slug' => 'python', 'icon' => 'python'],
            ['name' => 'PySide6', 'slug' => 'pyside6', 'icon' => 'pyside6'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'icon' => 'javascript'],
            ['name' => 'React', 'slug' => 'react', 'icon' => 'react'],
            ['name' => 'Vue', 'slug' => 'vue', 'icon' => 'vue'],
            ['name' => 'MySQL', 'slug' => 'mysql', 'icon' => 'mysql'],
            ['name' => 'SQLite', 'slug' => 'sqlite', 'icon' => 'sqlite'],
            ['name' => 'Tailwind CSS', 'slug' => 'tailwind-css', 'icon' => 'tailwind'],
            ['name' => 'Node.js', 'slug' => 'nodejs', 'icon' => 'nodejs'],
            ['name' => 'Discord API', 'slug' => 'discord-api', 'icon' => 'discord'],
        ];

        foreach ($technologies as $tech) {
            Technology::create($tech);
        }

        // Create sample projects
        $projects = [
            [
                'title' => 'ABSIS School Attendance System',
                'description' => 'A comprehensive school attendance management system built with Laravel and React. Features include real-time attendance tracking, automated reporting, and parent notifications via SMS and email.',
                'category' => 'Website',
                'status' => 'Completed',
                'role' => 'Lead Developer',
                'start_date' => '2024-01-15',
                'end_date' => '2024-06-30',
                'github_url' => 'https://github.com/example/absis-attendance',
                'demo_url' => 'https://absis.example.com',
                'notes' => 'Used by 3 schools with 2000+ daily active users.',
                'technologies' => ['PHP', 'Laravel', 'React', 'MySQL', 'Tailwind CSS'],
                'features' => [
                    ['name' => 'Real-time Attendance', 'description' => 'Live attendance tracking with instant sync'],
                    ['name' => 'Automated Reports', 'description' => 'Weekly and monthly attendance reports'],
                    ['name' => 'Parent Notifications', 'description' => 'SMS and email alerts for absences'],
                    ['name' => 'Multi-school Support', 'description' => 'Support for multiple school branches'],
                ],
            ],
            [
                'title' => 'SmartPresence Mobile App',
                'description' => 'Native Android attendance app built with Kotlin and Jetpack Compose. Features QR code scanning, offline mode, and biometric authentication.',
                'category' => 'Mobile App',
                'status' => 'In Progress',
                'role' => 'Mobile Developer',
                'start_date' => '2025-03-01',
                'end_date' => null,
                'github_url' => 'https://github.com/example/smartpresence',
                'demo_url' => null,
                'notes' => 'Currently in beta testing with 500 users.',
                'technologies' => ['JavaScript', 'React', 'Node.js'],
                'features' => [
                    ['name' => 'QR Code Scanning', 'description' => 'Quick attendance via QR code'],
                    ['name' => 'Offline Mode', 'description' => 'Works without internet connection'],
                    ['name' => 'Biometric Auth', 'description' => 'Fingerprint and face recognition'],
                ],
            ],
            [
                'title' => 'Discord Study Bot',
                'description' => 'A Discord bot for managing study groups, scheduling sessions, and tracking study hours. Built with Node.js and Discord API.',
                'category' => 'Bot',
                'status' => 'Completed',
                'role' => 'Developer',
                'start_date' => '2024-08-01',
                'end_date' => '2024-11-15',
                'github_url' => 'https://github.com/example/study-bot',
                'demo_url' => null,
                'notes' => 'Serving 50+ study groups with 2000+ members.',
                'technologies' => ['JavaScript', 'Node.js', 'Discord API', 'SQLite'],
                'features' => [
                    ['name' => 'Study Session Scheduler', 'description' => 'Schedule and manage study sessions'],
                    ['name' => 'Hour Tracking', 'description' => 'Track individual study hours'],
                    ['name' => 'Leaderboard', 'description' => 'Gamified study hour rankings'],
                    ['name' => 'Resource Sharing', 'description' => 'Share study materials in channels'],
                ],
            ],
            [
                'title' => 'Portfolio Dashboard',
                'description' => 'Personal portfolio and project management dashboard built with Vue and Laravel. Features project showcase, analytics, and contact form.',
                'category' => 'Website',
                'status' => 'Completed',
                'role' => 'Full Stack Developer',
                'start_date' => '2024-03-01',
                'end_date' => '2024-05-15',
                'github_url' => 'https://github.com/example/portfolio',
                'demo_url' => 'https://portfolio.example.com',
                'notes' => 'Personal portfolio site with 10k+ monthly visitors.',
                'technologies' => ['PHP', 'Laravel', 'Vue', 'MySQL', 'Tailwind CSS'],
                'features' => [
                    ['name' => 'Project Showcase', 'description' => 'Interactive project gallery'],
                    ['name' => 'Analytics Dashboard', 'description' => 'Visitor and interaction analytics'],
                    ['name' => 'Contact Form', 'description' => 'Secure contact form with validation'],
                ],
            ],
            [
                'title' => 'Inventory Management API',
                'description' => 'RESTful API for inventory management with real-time stock tracking, order management, and supplier management. Built with Laravel and MySQL.',
                'category' => 'API',
                'status' => 'In Progress',
                'role' => 'Backend Developer',
                'start_date' => '2025-01-10',
                'end_date' => null,
                'github_url' => 'https://github.com/example/inventory-api',
                'demo_url' => null,
                'notes' => 'API serving 50+ requests per second.',
                'technologies' => ['PHP', 'Laravel', 'MySQL'],
                'features' => [
                    ['name' => 'Stock Tracking', 'description' => 'Real-time inventory tracking'],
                    ['name' => 'Order Management', 'description' => 'Complete order lifecycle management'],
                    ['name' => 'Supplier Portal', 'description' => 'Supplier management interface'],
                    ['name' => 'Webhook Support', 'description' => 'Event-driven notifications'],
                ],
            ],
            [
                'title' => 'PySide6 Desktop App',
                'description' => 'Cross-platform desktop application for data visualization and reporting. Built with Python and PySide6.',
                'category' => 'Desktop App',
                'status' => 'Completed',
                'role' => 'Desktop Developer',
                'start_date' => '2024-06-01',
                'end_date' => '2024-09-30',
                'github_url' => 'https://github.com/example/pyside6-app',
                'demo_url' => null,
                'notes' => 'Used by 200+ daily active users.',
                'technologies' => ['Python', 'PySide6', 'SQLite'],
                'features' => [
                    ['name' => 'Data Visualization', 'description' => 'Interactive charts and graphs'],
                    ['name' => 'Report Generation', 'description' => 'PDF and Excel report export'],
                    ['name' => 'Offline Mode', 'description' => 'Full offline functionality'],
                ],
            ],
            [
                'title' => 'E-commerce Platform',
                'description' => 'Full-featured e-commerce platform with product management, payment integration, and order tracking. Built with Laravel and React.',
                'category' => 'Website',
                'status' => 'Planning',
                'role' => 'Lead Developer',
                'start_date' => '2025-06-01',
                'end_date' => null,
                'github_url' => null,
                'demo_url' => null,
                'notes' => 'Planning phase, expected launch Q4 2025.',
                'technologies' => ['PHP', 'Laravel', 'React', 'MySQL', 'Tailwind CSS'],
                'features' => [
                    ['name' => 'Product Catalog', 'description' => 'Advanced product management'],
                    ['name' => 'Payment Gateway', 'description' => 'Multiple payment options'],
                    ['name' => 'Order Tracking', 'description' => 'Real-time order status'],
                ],
            ],
            [
                'title' => 'Task Management Bot',
                'description' => 'Telegram bot for task management with reminders, team collaboration, and progress tracking. Built with Python and SQLite.',
                'category' => 'Bot',
                'status' => 'Archived',
                'role' => 'Developer',
                'start_date' => '2023-05-01',
                'end_date' => '2023-08-30',
                'github_url' => 'https://github.com/example/task-bot',
                'demo_url' => null,
                'notes' => 'Archived due to API changes.',
                'technologies' => ['Python', 'SQLite'],
                'features' => [
                    ['name' => 'Task Creation', 'description' => 'Quick task creation via commands'],
                    ['name' => 'Reminders', 'description' => 'Customizable task reminders'],
                    ['name' => 'Team Collaboration', 'description' => 'Shared task lists'],
                ],
            ],
            [
                'title' => 'Weather Dashboard',
                'description' => 'Real-time weather dashboard with interactive maps, forecasts, and alerts. Built with Vue and Node.js.',
                'category' => 'Website',
                'status' => 'Completed',
                'role' => 'Frontend Developer',
                'start_date' => '2024-02-01',
                'end_date' => '2024-04-15',
                'github_url' => 'https://github.com/example/weather-dash',
                'demo_url' => 'https://weather.example.com',
                'notes' => '5000+ daily active users.',
                'technologies' => ['JavaScript', 'Vue', 'Node.js', 'Tailwind CSS'],
                'features' => [
                    ['name' => 'Interactive Maps', 'description' => 'Weather overlay maps'],
                    ['name' => '7-Day Forecast', 'description' => 'Extended weather forecasts'],
                    ['name' => 'Weather Alerts', 'description' => 'Severe weather notifications'],
                ],
            ],
            [
                'title' => 'Learning Management System',
                'description' => 'Complete LMS with course management, student progress tracking, and certification. Built with Laravel and MySQL.',
                'category' => 'Website',
                'status' => 'In Progress',
                'role' => 'Full Stack Developer',
                'start_date' => '2025-02-01',
                'end_date' => null,
                'github_url' => 'https://github.com/example/lms',
                'demo_url' => null,
                'notes' => 'Currently serving 1000+ students.',
                'technologies' => ['PHP', 'Laravel', 'MySQL', 'Tailwind CSS'],
                'features' => [
                    ['name' => 'Course Builder', 'description' => 'Drag-and-drop course creation'],
                    ['name' => 'Progress Tracking', 'description' => 'Student progress analytics'],
                    ['name' => 'Certification', 'description' => 'Auto-generated certificates'],
                    ['name' => 'Quiz Engine', 'description' => 'Interactive quizzes and exams'],
                ],
            ],
            [
                'title' => 'Fitness Tracker API',
                'description' => 'RESTful API for fitness tracking with workout plans, progress photos, and nutrition logging. Built with Laravel and MySQL.',
                'category' => 'API',
                'status' => 'Completed',
                'role' => 'Backend Developer',
                'start_date' => '2024-04-01',
                'end_date' => '2024-07-30',
                'github_url' => 'https://github.com/example/fitness-api',
                'demo_url' => null,
                'notes' => 'API powering 3 mobile apps.',
                'technologies' => ['PHP', 'Laravel', 'MySQL'],
                'features' => [
                    ['name' => 'Workout Plans', 'description' => 'Customizable workout routines'],
                    ['name' => 'Progress Tracking', 'description' => 'Photo and metric tracking'],
                    ['name' => 'Nutrition Log', 'description' => 'Daily nutrition tracking'],
                ],
            ],
            [
                'title' => 'Chat Application',
                'description' => 'Real-time chat application with file sharing, voice messages, and group chats. Built with Node.js and React.',
                'category' => 'Website',
                'status' => 'Archived',
                'role' => 'Full Stack Developer',
                'start_date' => '2023-01-01',
                'end_date' => '2023-06-30',
                'github_url' => 'https://github.com/example/chat-app',
                'demo_url' => null,
                'notes' => 'Archived, replaced by newer solution.',
                'technologies' => ['JavaScript', 'React', 'Node.js', 'SQLite'],
                'features' => [
                    ['name' => 'Real-time Messaging', 'description' => 'Instant message delivery'],
                    ['name' => 'File Sharing', 'description' => 'Secure file uploads'],
                    ['name' => 'Voice Messages', 'description' => 'Voice message recording'],
                ],
            ],
        ];

        foreach ($projects as $projectData) {
            $techNames = $projectData['technologies'];
            $features = $projectData['features'];
            unset($projectData['technologies'], $projectData['features']);

            $projectData['slug'] = Str::slug($projectData['title']);
            $projectData['category_id'] = Category::where('slug', Str::slug($projectData['category']))->first()->id;
            $projectData['status_id'] = Status::where('slug', Str::slug($projectData['status']))->first()->id;
            unset($projectData['category'], $projectData['status']);

            $project = Project::create($projectData);

            // Attach technologies
            $techIds = Technology::whereIn('name', $techNames)->pluck('id');
            $project->technologies()->attach($techIds);

            // Create features
            foreach ($features as $feature) {
                Feature::create([
                    'project_id' => $project->id,
                    'name' => $feature['name'],
                    'description' => $feature['description'],
                ]);
            }
        }

        // Create a default user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
    }
}
