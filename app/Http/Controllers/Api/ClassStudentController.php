<?php

namespace App\Http\Controllers\Api;

use App\Models\ClassStudent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassStudentResource;
use App\Http\Resources\ClassStudentCollection;
use App\Http\Requests\ClassStudentStoreRequest;
use App\Http\Requests\ClassStudentUpdateRequest;

class ClassStudentController extends Controller
{
    public function index(Request $request): ClassStudentCollection
    {
        $this->authorize('view-any', ClassStudent::class);

        $search = $request->get('search', '');

        $classStudents = ClassStudent::search($search)
            ->latest()
            ->paginate();

        return new ClassStudentCollection($classStudents);
    }

    public function store(
        ClassStudentStoreRequest $request
    ): ClassStudentResource {
        $this->authorize('create', ClassStudent::class);

        $validated = $request->validated();

        $classStudent = ClassStudent::create($validated);

        return new ClassStudentResource($classStudent);
    }

    public function show(
        Request $request,
        ClassStudent $classStudent
    ): ClassStudentResource {
        $this->authorize('view', $classStudent);

        return new ClassStudentResource($classStudent);
    }

    public function update(
        ClassStudentUpdateRequest $request,
        ClassStudent $classStudent
    ): ClassStudentResource {
        $this->authorize('update', $classStudent);

        $validated = $request->validated();

        $classStudent->update($validated);

        return new ClassStudentResource($classStudent);
    }

    public function destroy(
        Request $request,
        ClassStudent $classStudent
    ): Response {
        $this->authorize('delete', $classStudent);

        $classStudent->delete();

        return response()->noContent();
    }
}
