<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClassStudent;
use App\Models\SessionStart;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassStudentSessionStartsTest extends TestCase
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
    public function it_gets_class_student_session_starts(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $sessionStarts = SessionStart::factory()
            ->count(2)
            ->create([
                'class_student_id' => $classStudent->id,
            ]);

        $response = $this->getJson(
            route('api.class-students.session-starts.index', $classStudent)
        );

        $response->assertOk()->assertSee($sessionStarts[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_class_student_session_starts(): void
    {
        $classStudent = ClassStudent::factory()->create();
        $data = SessionStart::factory()
            ->make([
                'class_student_id' => $classStudent->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.class-students.session-starts.store', $classStudent),
            $data
        );

        $this->assertDatabaseHas('session_starts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sessionStart = SessionStart::latest('id')->first();

        $this->assertEquals($classStudent->id, $sessionStart->class_student_id);
    }
}
