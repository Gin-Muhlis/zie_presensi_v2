<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\StudentCollection;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentController extends Controller
{
    public function index(Request $request): StudentCollection
    {
        $this->authorize('view-any', Student::class);

        $search = $request->get('search', '');

        $students = Student::search($search)
            ->latest()
            ->paginate();

        return new StudentCollection($students);
    }

    public function store(StudentStoreRequest $request): StudentResource
    {
        $this->authorize('create', Student::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $student = Student::create($validated);

        return new StudentResource($student);
    }

    public function show(Request $request, Student $student): StudentResource
    {
        $this->authorize('view', $student);

        return new StudentResource($student);
    }

    public function update(
        StudentUpdateRequest $request,
        Student $student
    ): StudentResource {
        $this->authorize('update', $student);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($student->image) {
                Storage::delete($student->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $student->update($validated);

        return new StudentResource($student);
    }

    public function destroy(Request $request, Student $student): Response
    {
        $this->authorize('delete', $student);

        if ($student->image) {
            Storage::delete($student->image);
        }

        $student->delete();

        return response()->noContent();
    }
}
