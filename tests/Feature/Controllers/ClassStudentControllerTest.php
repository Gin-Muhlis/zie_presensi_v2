<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ClassStudent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassStudentControllerTest extends TestCase
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
    public function it_displays_index_view_with_class_students(): void
    {
        $classStudents = ClassStudent::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('class-students.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.class_students.index')
            ->assertViewHas('classStudents');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_class_student(): void
    {
        $response = $this->get(route('class-students.create'));

        $response->assertOk()->assertViewIs('app.class_students.create');
    }

    /**
     * @test
     */
    public function it_stores_the_class_student(): void
    {
        $data = ClassStudent::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('class-students.store'), $data);

        $this->assertDatabaseHas('class_students', $data);

        $classStudent = ClassStudent::latest('id')->first();

        $response->assertRedirect(route('class-students.edit', $classStudent));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_class_student(): void
    {
        $classStudent = ClassStudent::factory()->create();

        $response = $this->get(route('class-students.show', $classStudent));

        $response
            ->assertOk()
            ->assertViewIs('app.class_students.show')
            ->assertViewHas('classStudent');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_class_student(): void
    {
        $classStudent = ClassStudent::factory()->create();

        $response = $this->get(route('class-students.edit', $classStudent));

        $response
            ->assertOk()
            ->assertViewIs('app.class_students.edit')
            ->assertViewHas('classStudent');
    }

    /**
     * @test
     */
    public function it_updates_the_class_student(): void
    {
        $classStudent = ClassStudent::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'code' => $this->faker->text(255),
        ];

        $response = $this->put(
            route('class-students.update', $classStudent),
            $data
        );

        $data['id'] = $classStudent->id;

        $this->assertDatabaseHas('class_students', $data);

        $response->assertRedirect(route('class-students.edit', $classStudent));
    }

    /**
     * @test
     */
    public function it_deletes_the_class_student(): void
    {
        $classStudent = ClassStudent::factory()->create();

        $response = $this->delete(
            route('class-students.destroy', $classStudent)
        );

        $response->assertRedirect(route('class-students.index'));

        $this->assertModelMissing($classStudent);
    }
}
