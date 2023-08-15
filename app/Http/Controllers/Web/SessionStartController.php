<?php

namespace App\Http\Controllers\Web;

use App\Models\Teacher;
use Illuminate\View\View;
use App\Models\SessionStart;
use Illuminate\Http\Request;
use App\Models\ClassStudent;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SessionStartStoreRequest;
use App\Http\Requests\SessionStartUpdateRequest;

class SessionStartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SessionStart::class);

        $search = $request->get('search', '');

        $sessionStarts = SessionStart::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.session_starts.index',
            compact('sessionStarts', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SessionStart::class);

        $teachers = Teacher::pluck('name', 'id');
        $classStudents = ClassStudent::pluck('name', 'id');

        return view(
            'app.session_starts.create',
            compact('teachers', 'classStudents')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SessionStartStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SessionStart::class);

        $validated = $request->validated();

        $sessionStart = SessionStart::create($validated);

        return redirect()
            ->route('session-starts.edit', $sessionStart)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SessionStart $sessionStart): View
    {
        $this->authorize('view', $sessionStart);

        return view('app.session_starts.show', compact('sessionStart'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SessionStart $sessionStart): View
    {
        $this->authorize('update', $sessionStart);

        $teachers = Teacher::pluck('name', 'id');
        $classStudents = ClassStudent::pluck('name', 'id');

        return view(
            'app.session_starts.edit',
            compact('sessionStart', 'teachers', 'classStudents')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SessionStartUpdateRequest $request,
        SessionStart $sessionStart
    ): RedirectResponse {
        $this->authorize('update', $sessionStart);

        $validated = $request->validated();

        $sessionStart->update($validated);

        return redirect()
            ->route('session-starts.edit', $sessionStart)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SessionStart $sessionStart
    ): RedirectResponse {
        $this->authorize('delete', $sessionStart);

        $sessionStart->delete();

        return redirect()
            ->route('session-starts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
