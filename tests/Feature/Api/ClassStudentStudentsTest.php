<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Student;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassStudentStudentsTest extends TestCase
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
    public function it_gets_class_student_students(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $students = Student::factory()
            ->count(2)
            ->create([
                'class_student_id' => $classStudent->id,
            ]);

        $response = $this->getJson(
            route('api.class-students.students.index', $classStudent)
        );

        $response->assertOk()->assertSee($students[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_class_student_students(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $data = Student::factory()
            ->make([
                'class_student_id' => $classStudent->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.class-students.students.store', $classStudent),
            $data
        );

        $this->assertDatabaseHas('students', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $student = Student::latest('id')->first();

        $this->assertEquals($classStudent->id, $student->class_student_id);
    }
}
