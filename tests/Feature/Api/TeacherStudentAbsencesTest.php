<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\StudentAbsence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherStudentAbsencesTest extends TestCase
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
    public function it_gets_teacher_student_absences(): void
    {
        $teacher = Teacher::factory()->create();
        $studentAbsences = StudentAbsence::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.student-absences.index', $teacher)
        );

        $response->assertOk()->assertSee($studentAbsences[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_student_absences(): void
    {
        $teacher = Teacher::factory()->create();
        $data = StudentAbsence::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.student-absences.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('student_absences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $studentAbsence = StudentAbsence::latest('id')->first();

        $this->assertEquals($teacher->id, $studentAbsence->teacher_id);
    }
}
