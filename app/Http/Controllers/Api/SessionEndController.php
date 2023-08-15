<?php

namespace App\Http\Controllers\Api;

use App\Models\SessionEnd;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionEndResource;
use App\Http\Resources\SessionEndCollection;
use App\Http\Requests\SessionEndStoreRequest;
use App\Http\Requests\SessionEndUpdateRequest;

class SessionEndController extends Controller
{
    public function index(Request $request): SessionEndCollection
    {
        $this->authorize('view-any', SessionEnd::class);

        $search = $request->get('search', '');

        $sessionEnds = SessionEnd::search($search)
            ->latest()
            ->paginate();

        return new SessionEndCollection($sessionEnds);
    }

    public function store(SessionEndStoreRequest $request): SessionEndResource
    {
        $this->authorize('create', SessionEnd::class);

        $validated = $request->validated();

        $sessionEnd = SessionEnd::create($validated);

        return new SessionEndResource($sessionEnd);
    }

    public function show(
        Request $request,
        SessionEnd $sessionEnd
    ): SessionEndResource {
        $this->authorize('view', $sessionEnd);

        return new SessionEndResource($sessionEnd);
    }

    public function update(
        SessionEndUpdateRequest $request,
        SessionEnd $sessionEnd
    ): SessionEndResource {
        $this->authorize('update', $sessionEnd);

        $validated = $request->validated();

        $sessionEnd->update($validated);

        return new SessionEndResource($sessionEnd);
    }

    public function destroy(Request $request, SessionEnd $sessionEnd): Response
    {
        $this->authorize('delete', $sessionEnd);

        $sessionEnd->delete();

        return response()->noContent();
    }
}
