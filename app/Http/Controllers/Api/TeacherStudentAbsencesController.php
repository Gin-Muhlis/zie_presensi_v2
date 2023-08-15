<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAbsenceResource;
use App\Http\Resources\StudentAbsenceCollection;

class TeacherStudentAbsencesController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): StudentAbsenceCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $studentAbsences = $teacher
            ->studentAbsences()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentAbsenceCollection($studentAbsences);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): StudentAbsenceResource {
        $this->authorize('create', StudentAbsence::class);

        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'presence_id' => ['required', 'exists:presences,id'],
            'time' => ['required', 'date'],
        ]);

        $studentAbsence = $teacher->studentAbsences()->create($validated);

        return new StudentAbsenceResource($studentAbsence);
    }
}
