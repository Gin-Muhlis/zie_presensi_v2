<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SessionStart;

use App\Models\Teacher;
use App\Models\ClassStudent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionStartControllerTest extends TestCase
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
    public function it_displays_index_view_with_session_starts(): void
    {
        $sessionStarts = SessionStart::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('session-starts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.session_starts.index')
            ->assertViewHas('sessionStarts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_session_start(): void
    {
        $response = $this->get(route('session-starts.create'));

        $response->assertOk()->assertViewIs('app.session_starts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_session_start(): void
    {
        $data = SessionStart::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('session-starts.store'), $data);

        $this->assertDatabaseHas('session_starts', $data);

        $sessionStart = SessionStart::latest('id')->first();

        $response->assertRedirect(route('session-starts.edit', $sessionStart));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_session_start(): void
    {
        $sessionStart = SessionStart::factory()->create();

        $response = $this->get(route('session-starts.show', $sessionStart));

        $response
            ->assertOk()
            ->assertViewIs('app.session_starts.show')
            ->assertViewHas('sessionStart');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_session_start(): void
    {
        $sessionStart = SessionStart::factory()->create();

        $response = $this->get(route('session-starts.edit', $sessionStart));

        $response
            ->assertOk()
            ->assertViewIs('app.session_starts.edit')
            ->assertViewHas('sessionStart');
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

        $response = $this->put(
            route('session-starts.update', $sessionStart),
            $data
        );

        $data['id'] = $sessionStart->id;

        $this->assertDatabaseHas('session_starts', $data);

        $response->assertRedirect(route('session-starts.edit', $sessionStart));
    }

    /**
     * @test
     */
    public function it_deletes_the_session_start(): void
    {
        $sessionStart = SessionStart::factory()->create();

        $response = $this->delete(
            route('session-starts.destroy', $sessionStart)
        );

        $response->assertRedirect(route('session-starts.index'));

        $this->assertModelMissing($sessionStart);
    }
}
