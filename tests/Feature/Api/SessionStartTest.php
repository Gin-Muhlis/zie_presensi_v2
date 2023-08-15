<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SessionStart;

use App\Models\Teacher;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionStartTest extends TestCase
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
    public function it_gets_session_starts_list(): void
    {
        $sessionStarts = SessionStart::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.session-starts.index'));

        $response->assertOk()->assertSee($sessionStarts[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_session_start(): void
    {
        $data = SessionStart::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.session-starts.store'), $data);

        $this->assertDatabaseHas('session_starts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_session_start(): void
    {
        $sessionStart = SessionStart::factory()->create();

        $teacher = Teacher::factory()->create();
        $classStudent = ClassStudent::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'teacher_id' => $teacher->id,
            'class_student_id' => $classStudent->id,
        ];

        $response = $this->putJson(
            route('api.session-starts.update', $sessionStart),
            $data
        );

        $data['id'] = $sessionStart->id;

        $this->assertDatabaseHas('session_starts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_session_start(): void
    {
        $sessionStart = SessionStart::factory()->create();

        $response = $this->deleteJson(
            route('api.session-starts.destroy', $sessionStart)
        );

        $this->assertModelMissing($sessionStart);

        $response->assertNoContent();
    }
}
