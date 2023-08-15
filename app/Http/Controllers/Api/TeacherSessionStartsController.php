<?php

namespace App\Http\Controllers\Api;

use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionStartResource;
use App\Http\Resources\SessionStartCollection;

class TeacherSessionStartsController extends Controller
{
    public function index(
        Request $request,
        Teacher $teacher
    ): SessionStartCollection {
        $this->authorize('view', $teacher);

        $search = $request->get('search', '');

        $sessionStarts = $teacher
            ->sessionStarts()
            ->search($search)
            ->latest()
            ->paginate();

        return new SessionStartCollection($sessionStarts);
    }

    public function store(
        Request $request,
        Teacher $teacher
    ): SessionStartResource {
        $this->authorize('create', SessionStart::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'class_student_id' => ['required', 'exists:class_students,id'],
        ]);

        $sessionStart = $teacher->sessionStarts()->create($validated);

        return new SessionStartResource($sessionStart);
    }
}
