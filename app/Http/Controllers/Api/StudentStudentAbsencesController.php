<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAbsenceResource;
use App\Http\Resources\StudentAbsenceCollection;

class StudentStudentAbsencesController extends Controller
{
    public function index(
        Request $request,
        Student $student
    ): StudentAbsenceCollection {
        $this->authorize('view', $student);

        $search = $request->get('search', '');

        $studentAbsences = $student
            ->studentAbsences()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentAbsenceCollection($studentAbsences);
    }

    public function store(
        Request $request,
        Student $student
    ): StudentAbsenceResource {
        $this->authorize('create', StudentAbsence::class);

        $validated = $request->validate([
            'teacher_id' => ['required', 'exists:teachers,id'],
            'presence_id' => ['required', 'exists:presences,id'],
            'time' => ['required', 'date'],
        ]);

        $studentAbsence = $student->studentAbsences()->create($validated);

        return new StudentAbsenceResource($studentAbsence);
    }
}
