<?php

namespace Database\Factories;

use App\Enums\ExceptionStatusEnum;
use App\Models\Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exception>
 */
class ExceptionFactory extends Factory
{
    protected $model = Exception::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'host'                       => $this->faker->url(),
            'method'                     => 'POST',
            'fullUrl'                    => $this->faker->url(),
            'exception'                  => $this->faker->text(200),
            'environment'                => $this->faker->randomElement(['production', 'staging']),
            'error'                      => $this->faker->text(100),
            'line'                       => 25,
            'file'                       => 'test.php',
            'storage'                    => 'file',
            'file_type'                  => '.php',
            'class'                      => 'TestClass',
            'status'                     => $this->faker->randomElement([ExceptionStatusEnum::Open->value, ExceptionStatusEnum::Read->value, ExceptionStatusEnum::Fixed->value]),
            'mailed'                     => $this->faker->boolean(),
            'additional'                 => $this->faker->text(300),
            'executor'                   => 'php',
            'project_version'            => 'v2',
            'issue_id'                   => $this->faker->uuid(),
        ];
    }
}
