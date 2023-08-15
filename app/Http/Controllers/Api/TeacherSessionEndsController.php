<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionEndResource;
use App\Http\Resources\SessionEndCollection;

class TeacherSessionEndsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): SessionEndCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $sessionEnds = $teacher
            ->sessionEnds()
            ->search($search)
            ->latest()
            ->paginate();

        return new SessionEndCollection($sessionEnds);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): SessionEndResource {
        $this->authorize('create', SessionEnd::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'class_student_id' => ['required', 'exists:class_students,id'],
        ]);

        $sessionEnd = $teacher->sessionEnds()->create($validated);

        return new SessionEndResource($sessionEnd);
    }
}
