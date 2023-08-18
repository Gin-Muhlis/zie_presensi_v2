<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->text(255),
            'nis' => $this->faker->text(9),
            'gender' => \Arr::random(['male', 'female', 'other']),
            'password' => $this->faker->text(255),
            'class_student_id' => \App\Models\ClassStudent::factory(),
        ];
    }
}
