<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ClassStudent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassStudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassStudent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->text(255),
        ];
    }
}
