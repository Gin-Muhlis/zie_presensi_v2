<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\StudentAbsence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceStudentAbsencesTest extends TestCase
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
    public function it_gets_presence_student_absences(): void
    {
        $presence = Presence::factory()->create();
        $studentAbsences = StudentAbsence::factory()
            ->count(2)
            ->create([
                'presence_id' => $presence->id,
            ]);

        $response = $this->getJson(
            route('api.presences.student-absences.index', $presence)
        );

        $response->assertOk()->assertSee($studentAbsences[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_presence_student_absences(): void
    {
        $presence = Presence::factory()->create();
        $data = StudentAbsence::factory()
            ->make([
                'presence_id' => $presence->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.presences.student-absences.store', $presence),
            $data
        );

        $this->assertDatabaseHas('student_absences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $studentAbsence = StudentAbsence::latest('id')->first();

        $this->assertEquals($presence->id, $studentAbsence->presence_id);
    }
}
