<?php

namespace Database\Seeders;

use App\Models\Exception;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::withoutEvents(function () {
            Project::factory()->count(20)->has(Exception::factory()->count(10))->create();
        });
    }
}
