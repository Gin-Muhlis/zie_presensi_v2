<?php

namespace App\Http\Controllers\Api;

use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionStartResource;
use App\Http\Resources\SessionStartCollection;

class ClassStudentSessionStartsController extends Controller
{
    public function index(
        Request $request,
        ClassStudent $classStudent
    ): SessionStartCollection {
        $this->authorize('view', $classStudent);

        $search = $request->get('search', '');

        $sessionStarts = $classStudent
            ->sessionStarts()
            ->search($search)
            ->latest()
            ->paginate();

        return new SessionStartCollection($sessionStarts);
    }

    public function store(
        Request $request,
        ClassStudent $classStudent
    ): SessionStartResource {
        $this->authorize('create', SessionStart::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $sessionStart = $classStudent->sessionStarts()->create($validated);

        return new SessionStartResource($sessionStart);
    }
}
