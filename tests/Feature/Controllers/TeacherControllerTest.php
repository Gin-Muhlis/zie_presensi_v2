<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Teacher;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherControllerTest extends TestCase
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
    public function it_displays_index_view_with_teachers(): void
    {
        $teachers = Teacher::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('teachers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.teachers.index')
            ->assertViewHas('teachers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_teacher(): void
    {
        $response = $this->get(route('teachers.create'));

        $response->assertOk()->assertViewIs('app.teachers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_teacher(): void
    {
        $data = Teacher::factory()
            ->make()
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->post(route('teachers.store'), $data);

        unset($data['password']);

        $this->assertDatabaseHas('teachers', $data);

        $teacher = Teacher::latest('id')->first();

        $response->assertRedirect(route('teachers.edit', $teacher));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_teacher(): void
    {
        $teacher = Teacher::factory()->create();

        $response = $this->get(route('teachers.show', $teacher));

        $response
            ->assertOk()
            ->assertViewIs('app.teachers.show')
            ->assertViewHas('teacher');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_teacher(): void
    {
        $teacher = Teacher::factory()->create();

        $response = $this->get(route('teachers.edit', $teacher));

        $response
            ->assertOk()
            ->assertViewIs('app.teachers.edit')
            ->assertViewHas('teacher');
    }

    /**
     * @test
     */
    public function it_updates_the_teacher(): void
    {
        $teacher = Teacher::factory()->create();

        $data = [
            'email' => $this->faker->text(255),
            'name' => $this->faker->name(),
            'gender' => \Arr::random(['male', 'female', 'other']),
        ];

        $data['password'] = \Str::random('8');

        $response = $this->put(route('teachers.update', $teacher), $data);

        unset($data['password']);

        $data['id'] = $teacher->id;

        $this->assertDatabaseHas('teachers', $data);

        $response->assertRedirect(route('teachers.edit', $teacher));
    }

    /**
     * @test
     */
    public function it_deletes_the_teacher(): void
    {
        $teacher = Teacher::factory()->create();

        $response = $this->delete(route('teachers.destroy', $teacher));

        $response->assertRedirect(route('teachers.index'));

        $this->assertModelMissing($teacher);
    }
}
