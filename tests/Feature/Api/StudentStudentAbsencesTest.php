<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\StudentAbsence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentStudentAbsencesTest extends TestCase
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
    public function it_gets_student_student_absences(): void
    {
        $student = Student::factory()->create();
        $studentAbsences = StudentAbsence::factory()
            ->count(2)
            ->create([
                'student_id' => $student->id,
            ]);

        $response = $this->getJson(
            route('api.students.student-absences.index', $student)
        );

        $response->assertOk()->assertSee($studentAbsences[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_student_student_absences(): void
    {
        $student = Student::factory()->create();
        $data = StudentAbsence::factory()
            ->make([
                'student_id' => $student->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.students.student-absences.store', $student),
            $data
        );

        $this->assertDatabaseHas('student_absences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $studentAbsence = StudentAbsence::latest('id')->first();

        $this->assertEquals($student->id, $studentAbsence->student_id);
    }
}
