<?php

namespace App\Http\Controllers\Web;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Presence;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\StudentAbsence;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StudentAbsenceStoreRequest;
use App\Http\Requests\StudentAbsenceUpdateRequest;

class StudentAbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', StudentAbsence::class);

        $search = $request->get('search', '');

        $studentAbsences = StudentAbsence::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.student_absences.index',
            compact('studentAbsences', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', StudentAbsence::class);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $presences = Presence::pluck('name', 'id');

        return view(
            'app.student_absences.create',
            compact('students', 'teachers', 'presences')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentAbsenceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', StudentAbsence::class);

        $validated = $request->validated();

        $studentAbsence = StudentAbsence::create($validated);

        return redirect()
            ->route('student-absences.edit', $studentAbsence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, StudentAbsence $studentAbsence): View
    {
        $this->authorize('view', $studentAbsence);

        return view('app.student_absences.show', compact('studentAbsence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, StudentAbsence $studentAbsence): View
    {
        $this->authorize('update', $studentAbsence);

        $students = Student::pluck('name', 'id');
        $teachers = Teacher::pluck('name', 'id');
        $presences = Presence::pluck('name', 'id');

        return view(
            'app.student_absences.edit',
            compact('studentAbsence', 'students', 'teachers', 'presences')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        StudentAbsenceUpdateRequest $request,
        StudentAbsence $studentAbsence
    ): RedirectResponse {
        $this->authorize('update', $studentAbsence);

        $validated = $request->validated();

        $studentAbsence->update($validated);

        return redirect()
            ->route('student-absences.edit', $studentAbsence)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        StudentAbsence $studentAbsence
    ): RedirectResponse {
        $this->authorize('delete', $studentAbsence);

        $studentAbsence->delete();

        return redirect()
            ->route('student-absences.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
