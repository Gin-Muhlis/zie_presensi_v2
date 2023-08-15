<?php

namespace App\Http\Controllers\Api;

use App\Models\ClassStudent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentCollection;

class ClassStudentStudentsController extends Controller
{
    public function index(
        Request $request,
        ClassStudent $classStudent
    ): StudentCollection {
        $this->authorize('view', $classStudent);

        $search = $request->get('search', '');

        $students = $classStudent
            ->students()
            ->search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    public function store(
        Request $request,
        ClassStudent $classStudent
    ): StudentResource {
        $this->authorize('create', Student::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'nis' => ['required', 'max:9', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
            'gender' => ['required', 'in:laki-laki,perempuan,lainnya'],
            'passsword' => ['required', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $student = $classStudent->students()->create($validated);

        return new StudentResource($student);
    }
}
