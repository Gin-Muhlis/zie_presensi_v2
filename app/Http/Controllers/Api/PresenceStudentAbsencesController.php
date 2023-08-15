<?php

namespace App\Http\Controllers\Api;

use App\Models\Presence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAbsenceResource;
use App\Http\Resources\StudentAbsenceCollection;

class PresenceStudentAbsencesController extends Controller
{
    public function index(
        Request $request,
        Presence $presence
    ): StudentAbsenceCollection {
        $this->authorize('view', $presence);

        $search = $request->get('search', '');

        $studentAbsences = $presence
            ->studentAbsences()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentAbsenceCollection($studentAbsences);
    }

    public function store(
        Request $request,
        Presence $presence
    ): StudentAbsenceResource {
        $this->authorize('create', StudentAbsence::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'time' => ['required', 'date'],
        ]);

        $studentAbsence = $presence->studentAbsences()->create($validated);

        return new StudentAbsenceResource($studentAbsence);
    }
}
