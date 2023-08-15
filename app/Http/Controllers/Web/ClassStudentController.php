<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use App\Models\ClassStudent;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ClassStudentStoreRequest;
use App\Http\Requests\ClassStudentUpdateRequest;

class ClassStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ClassStudent::class);

        $search = $request->get('search', '');

        $classStudents = ClassStudent::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.class_students.index',
            compact('classStudents', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ClassStudent::class);

        return view('app.class_students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassStudentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ClassStudent::class);

        $validated = $request->validated();

        $classStudent = ClassStudent::create($validated);

        return redirect()
            ->route('class-students.edit', $classStudent)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ClassStudent $classStudent): View
    {
        $this->authorize('view', $classStudent);

        return view('app.class_students.show', compact('classStudent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ClassStudent $classStudent): View
    {
        $this->authorize('update', $classStudent);

        return view('app.class_students.edit', compact('classStudent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ClassStudentUpdateRequest $request,
        ClassStudent $classStudent
    ): RedirectResponse {
        $this->authorize('update', $classStudent);

        $validated = $request->validated();

        $classStudent->update($validated);

        return redirect()
            ->route('class-students.edit', $classStudent)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ClassStudent $classStudent
    ): RedirectResponse {
        $this->authorize('delete', $classStudent);

        $classStudent->delete();

        return redirect()
            ->route('class-students.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
