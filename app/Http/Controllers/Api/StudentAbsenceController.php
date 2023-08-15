<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StudentAbsence;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentAbsenceResource;
use App\Http\Resources\StudentAbsenceCollection;
use App\Http\Requests\StudentAbsenceStoreRequest;
use App\Http\Requests\StudentAbsenceUpdateRequest;

class StudentAbsenceController extends Controller
{
    public function index(Request $request): StudentAbsenceCollection
    {
        $this->authorize('view-any', StudentAbsence::class);

        $search = $request->get('search', '');

        $studentAbsences = StudentAbsence::search($search)
            ->latest()
            ->paginate();

        return new StudentAbsenceCollection($studentAbsences);
    }

    public function store(
        StudentAbsenceStoreRequest $request
    ): StudentAbsenceResource {
        $this->authorize('create', StudentAbsence::class);

        $validated = $request->validated();

        $studentAbsence = StudentAbsence::create($validated);

        return new StudentAbsenceResource($studentAbsence);
    }

    public function show(
        Request $request,
        StudentAbsence $studentAbsence
    ): StudentAbsenceResource {
        $this->authorize('view', $studentAbsence);

        return new StudentAbsenceResource($studentAbsence);
    }

    public function update(
        StudentAbsenceUpdateRequest $request,
        StudentAbsence $studentAbsence
    ): StudentAbsenceResource {
        $this->authorize('update', $studentAbsence);

        $validated = $request->validated();

        $studentAbsence->update($validated);

        return new StudentAbsenceResource($studentAbsence);
    }

    public function destroy(
        Request $request,
        StudentAbsence $studentAbsence
    ): Response {
        $this->authorize('delete', $studentAbsence);

        $studentAbsence->delete();

        return response()->noContent();
    }
}
