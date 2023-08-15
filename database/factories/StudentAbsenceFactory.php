<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StudentAbsence;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAbsenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentAbsence::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'time' => $this->faker->dateTime(),
            'student_id' => \App\Models\Student::factory(),
            'teacher_id' => \App\Models\Teacher::factory(),
            'presence_id' => \App\Models\Presence::factory(),
        ];
    }
}
