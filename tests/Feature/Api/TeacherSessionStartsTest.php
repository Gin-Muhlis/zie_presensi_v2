<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Teacher;
use App\Models\SessionStart;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherSessionStartsTest extends TestCase
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
    public function it_gets_teacher_session_starts(): void
    {
        $teacher = Teacher::factory()->create();
        $sessionStarts = SessionStart::factory()
            ->count(2)
            ->create([
                'teacher_id' => $teacher->id,
            ]);

        $response = $this->getJson(
            route('api.teachers.session-starts.index', $teacher)
        );

        $response->assertOk()->assertSee($sessionStarts[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_teacher_session_starts(): void
    {
        $teacher = Teacher::factory()->create();
        $data = SessionStart::factory()
            ->make([
                'teacher_id' => $teacher->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.teachers.session-starts.store', $teacher),
            $data
        );

        $this->assertDatabaseHas('session_starts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $sessionStart = SessionStart::latest('id')->first();

        $this->assertEquals($teacher->id, $sessionStart->teacher_id);
    }
}
