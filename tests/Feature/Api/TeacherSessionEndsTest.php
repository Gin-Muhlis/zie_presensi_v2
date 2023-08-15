<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\SessionEnd;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherSessionEndsTest extends TestCase
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
    public function it_gets_teacher_session_ends(): void
    {
        $teacher = Teacher::factory()->create();
        $sessionEnds = SessionEnd::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.session-ends.index', $teacher)
        );

        $response->assertOk()->assertSee($sessionEnds[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_session_ends(): void
    {
        $teacher = Teacher::factory()->create();
        $data = SessionEnd::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.session-ends.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('session_ends', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sessionEnd = SessionEnd::latest('id')->first();

        $this->assertEquals($teacher->id, $sessionEnd->teacher_id);
    }
}
