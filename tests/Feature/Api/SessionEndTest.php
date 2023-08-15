<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SessionEnd;

use App\Models\Teacher;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionEndTest extends TestCase
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
    public function it_gets_session_ends_list(): void
    {
        $sessionEnds = SessionEnd::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.session-ends.index'));

        $response->assertOk()->assertSee($sessionEnds[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_session_end(): void
    {
        $data = SessionEnd::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.session-ends.store'), $data);

        $this->assertDatabaseHas('session_ends', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_session_end(): void
    {
        $sessionEnd = SessionEnd::factory()->create();

        $teacher = Teacher::factory()->create();
        $classStudent = ClassStudent::factory()->create();

        $data = [
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'teacher_id' => $teacher->id,
            'class_student_id' => $classStudent->id,
        ];

        $response = $this->putJson(
            route('api.session-ends.update', $sessionEnd),
            $data
        );

        $data['id'] = $sessionEnd->id;

        $this->assertDatabaseHas('session_ends', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_session_end(): void
    {
        $sessionEnd = SessionEnd::factory()->create();

        $response = $this->deleteJson(
            route('api.session-ends.destroy', $sessionEnd)
        );

        $this->assertModelMissing($sessionEnd);

        $response->assertNoContent();
    }
}
