<?php

namespace Database\Factories;

use App\Models\Exception;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'exception_id' => Exception::factory(),
            'name'         => $this->faker->name,
            'email'        => $this->faker->email,
            'feedback'     => $this->faker->sentence,
        ];
    }
}
