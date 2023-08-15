<?php

namespace App\Http\Controllers\Web;

use App\Models\Teacher;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Teacher::class);

        $search = $request->get('search', '');

        $teachers = Teacher::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.teachers.index', compact('teachers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Teacher::class);

        return view('app.teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Teacher::class);

        $validated = $request->validated();

        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $teacher = Teacher::create($validated);

        return redirect()
            ->route('teachers.edit', $teacher)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Teacher $teacher): View
    {
        $this->authorize('view', $teacher);

        return view('app.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Teacher $teacher): View
    {
        $this->authorize('update', $teacher);

        return view('app.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TeacherUpdateRequest $request,
        Teacher $teacher
    ): RedirectResponse {
        $this->authorize('update', $teacher);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('image')) {
            if ($teacher->image) {
                Storage::delete($teacher->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $teacher->update($validated);

        return redirect()
            ->route('teachers.edit', $teacher)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Teacher $teacher
    ): RedirectResponse {
        $this->authorize('delete', $teacher);

        if ($teacher->image) {
            Storage::delete($teacher->image);
        }

        $teacher->delete();

        return redirect()
            ->route('teachers.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
