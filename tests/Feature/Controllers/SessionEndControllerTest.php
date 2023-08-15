<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SessionEnd;

use App\Models\Teacher;
use App\Models\ClassStudent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SessionEndControllerTest extends TestCase
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
    public function it_displays_index_view_with_session_ends(): void
    {
        $sessionEnds = SessionEnd::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('session-ends.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.session_ends.index')
            ->assertViewHas('sessionEnds');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_session_end(): void
    {
        $response = $this->get(route('session-ends.create'));

        $response->assertOk()->assertViewIs('app.session_ends.create');
    }

    /**
     * @test
     */
    public function it_stores_the_session_end(): void
    {
        $data = SessionEnd::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('session-ends.store'), $data);

        $this->assertDatabaseHas('session_ends', $data);

        $sessionEnd = SessionEnd::latest('id')->first();

        $response->assertRedirect(route('session-ends.edit', $sessionEnd));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_session_end(): void
    {
        $sessionEnd = SessionEnd::factory()->create();

        $response = $this->get(route('session-ends.show', $sessionEnd));

        $response
            ->assertOk()
            ->assertViewIs('app.session_ends.show')
            ->assertViewHas('sessionEnd');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_session_end(): void
    {
        $sessionEnd = SessionEnd::factory()->create();

        $response = $this->get(route('session-ends.edit', $sessionEnd));

        $response
            ->assertOk()
            ->assertViewIs('app.session_ends.edit')
            ->assertViewHas('sessionEnd');
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

        $response = $this->put(
            route('session-ends.update', $sessionEnd),
            $data
        );

        $data['id'] = $sessionEnd->id;

        $this->assertDatabaseHas('session_ends', $data);

        $response->assertRedirect(route('session-ends.edit', $sessionEnd));
    }

    /**
     * @test
     */
    public function it_deletes_the_session_end(): void
    {
        $sessionEnd = SessionEnd::factory()->create();

        $response = $this->delete(route('session-ends.destroy', $sessionEnd));

        $response->assertRedirect(route('session-ends.index'));

        $this->assertModelMissing($sessionEnd);
    }
}
