<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\StudentAbsence;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Presence;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentAbsenceControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_student_absences(): void
    {
        $studentAbsences = StudentAbsence::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('student-absences.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.student_absences.index')
            ->assertViewHas('studentAbsences');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_student_absence(): void
    {
        $response = $this->get(route('student-absences.create'));

        $response->assertOk()->assertViewIs('app.student_absences.create');
    }

    /**
     * @test
     */
    public function it_stores_the_student_absence(): void
    {
        $data = StudentAbsence::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('student-absences.store'), $data);

        $this->assertDatabaseHas('student_absences', $data);

        $studentAbsence = StudentAbsence::latest('id')->first();

        $response->assertRedirect(
            route('student-absences.edit', $studentAbsence)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_student_absence(): void
    {
        $studentAbsence = StudentAbsence::factory()->create();

        $response = $this->get(route('student-absences.show', $studentAbsence));

        $response
            ->assertOk()
            ->assertViewIs('app.student_absences.show')
            ->assertViewHas('studentAbsence');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_student_absence(): void
    {
        $studentAbsence = StudentAbsence::factory()->create();

        $response = $this->get(route('student-absences.edit', $studentAbsence));

        $response
            ->assertOk()
            ->assertViewIs('app.student_absences.edit')
            ->assertViewHas('studentAbsence');
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
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'student_id' => $student->id,
            'teacher_id' => $teacher->id,
            'presence_id' => $presence->id,
        ];

        $response = $this->put(
            route('student-absences.update', $studentAbsence),
            $data
        );

        $data['id'] = $studentAbsence->id;

        $this->assertDatabaseHas('student_absences', $data);

        $response->assertRedirect(
            route('student-absences.edit', $studentAbsence)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_student_absence(): void
    {
        $studentAbsence = StudentAbsence::factory()->create();

        $response = $this->delete(
            route('student-absences.destroy', $studentAbsence)
        );

        $response->assertRedirect(route('student-absences.index'));

        $this->assertModelMissing($studentAbsence);
    }
}
