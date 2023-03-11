<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->company(),
            'url' => $this->faker->url(),
            'key' => Str::random(50),
            'description' => $this->faker->text(200),
            'last_error_at' => $this->faker->randomElement([null, now()]),
            'notifications_enabled' => $this->faker->boolean(),
            'receive_email' => $this->faker->boolean(),
            'telegram_notification_enabled' => $this->faker->boolean(),
        ];
    }
}
