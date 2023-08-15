<?php

namespace Database\Factories;

use App\Models\SessionEnd;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionEndFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SessionEnd::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'teacher_id' => \App\Models\Teacher::factory(),
            'class_student_id' => \App\Models\ClassStudent::factory(),
        ];
    }
}
