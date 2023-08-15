<?php

namespace App\Http\Controllers\Api;

use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionEndResource;
use App\Http\Resources\SessionEndCollection;

class ClassStudentSessionEndsController extends Controller
{
    public function index(
        Request $request,
        ClassStudent $classStudent
    ): SessionEndCollection {
        $this->authorize('view', $classStudent);

        $search = $request->get('search', '');

        $sessionEnds = $classStudent
            ->sessionEnds()
            ->search($search)
            ->latest()
            ->paginate();

        return new SessionEndCollection($sessionEnds);
    }

    public function store(
        Request $request,
        ClassStudent $classStudent
    ): SessionEndResource {
        $this->authorize('create', SessionEnd::class);

        $validated = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'teacher_id' => ['required', 'exists:teachers,id'],
        ]);

        $sessionEnd = $classStudent->sessionEnds()->create($validated);

        return new SessionEndResource($sessionEnd);
    }
}
