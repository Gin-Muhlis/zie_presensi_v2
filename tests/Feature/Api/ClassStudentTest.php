<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClassStudent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClassStudentTest extends TestCase
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
    public function it_gets_class_students_list(): void
    {
        $classStudents = ClassStudent::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.class-students.index'));

        $response->assertOk()->assertSee($classStudents[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_class_student(): void
    {
        $data = ClassStudent::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.class-students.store'), $data);

        $this->assertDatabaseHas('class_students', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.class-students.update', $classStudent),
            $data
        );

        $data['id'] = $classStudent->id;

        $this->assertDatabaseHas('class_students', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_class_student(): void
    {
        $classStudent = ClassStudent::factory()->create();

        $response = $this->deleteJson(
            route('api.class-students.destroy', $classStudent)
        );

        $this->assertModelMissing($classStudent);

        $response->assertNoContent();
    }
}
