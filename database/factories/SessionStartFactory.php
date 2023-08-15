<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SessionStart;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionStartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SessionStart::class;

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
