<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StudentAbsence;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentAbsenceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_student_absences_list(): void
    {
        $studentAbsences = StudentAbsence::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.student-absences.index'));

        $response->assertOk()->assertSee($studentAbsences[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_student_absence(): void
    {
        $data = StudentAbsence::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.student-absences.store'), $data);

        $this->assertDatabaseHas('student_absences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_student_absence(): void
    {
        $studentAbsence = StudentAbsence::factory()->create();

        $student = Student::factory()->create();
        $teacher = Teacher::factory()->create();
        $presence = Presence::factory()->create();

        $data = [
            'time' => $this->faker->dateTime(),
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'presence_id' => $presence->id,
        ];

        $response = $this->putJson(
            route('api.student-absences.update', $studentAbsence),
            $data
        );

        $data['id'] = $studentAbsence->id;

        $this->assertDatabaseHas('student_absences', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_student_absence(): void
    {
        $studentAbsence = StudentAbsence::factory()->create();

        $response = $this->deleteJson(
            route('api.student-absences.destroy', $studentAbsence)
        );

        $this->assertModelMissing($studentAbsence);

        $response->assertNoContent();
    }
}
