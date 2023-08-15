<?php

namespace App\Http\Controllers\Web;

use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\SessionEnd;
use Illuminate\Http\Request;
use App\Models\ClassStudent;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SessionEndStoreRequest;
use App\Http\Requests\SessionEndUpdateRequest;

class SessionEndController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SessionEnd::class);

        $search = $request->get('search', '');

        $sessionEnds = SessionEnd::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.session_ends.index', compact('sessionEnds', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SessionEnd::class);

        $teachers = Teacher::pluck('name', 'id');
        $classStudents = ClassStudent::pluck('name', 'id');

        return view(
            'app.session_ends.create',
            compact('teachers', 'classStudents')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SessionEndStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SessionEnd::class);

        $validated = $request->validated();

        $sessionEnd = SessionEnd::create($validated);

        return redirect()
            ->route('session-ends.edit', $sessionEnd)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SessionEnd $sessionEnd): View
    {
        $this->authorize('view', $sessionEnd);

        return view('app.session_ends.show', compact('sessionEnd'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SessionEnd $sessionEnd): View
    {
        $this->authorize('update', $sessionEnd);

        $teachers = Teacher::pluck('name', 'id');
        $classStudents = ClassStudent::pluck('name', 'id');

        return view(
            'app.session_ends.edit',
            compact('sessionEnd', 'teachers', 'classStudents')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SessionEndUpdateRequest $request,
        SessionEnd $sessionEnd
    ): RedirectResponse {
        $this->authorize('update', $sessionEnd);

        $validated = $request->validated();

        $sessionEnd->update($validated);

        return redirect()
            ->route('session-ends.edit', $sessionEnd)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SessionEnd $sessionEnd
    ): RedirectResponse {
        $this->authorize('delete', $sessionEnd);

        $sessionEnd->delete();

        return redirect()
            ->route('session-ends.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
