<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SessionEnd;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassStudentSessionEndsTest extends TestCase
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
    public function it_gets_class_student_session_ends(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $sessionEnds = SessionEnd::factory()
            ->count(2)
            ->create([
                'class_student_id' => $classStudent->id,
            ]);

        $response = $this->getJson(
            route('api.class-students.session-ends.index', $classStudent)
        );

        $response->assertOk()->assertSee($sessionEnds[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_class_student_session_ends(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $data = SessionEnd::factory()
            ->make([
                'class_student_id' => $classStudent->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.class-students.session-ends.store', $classStudent),
            $data
        );

        $this->assertDatabaseHas('session_ends', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sessionEnd = SessionEnd::latest('id')->first();

        $this->assertEquals($classStudent->id, $sessionEnd->class_student_id);
    }
}
