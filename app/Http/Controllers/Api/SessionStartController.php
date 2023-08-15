<?php

namespace App\Http\Controllers\Api;

use App\Models\SessionStart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SessionStartResource;
use App\Http\Resources\SessionStartCollection;
use App\Http\Requests\SessionStartStoreRequest;
use App\Http\Requests\SessionStartUpdateRequest;

class SessionStartController extends Controller
{
    public function index(Request $request): SessionStartCollection
    {
        $this->authorize('view-any', SessionStart::class);

        $search = $request->get('search', '');

        $sessionStarts = SessionStart::search($search)
            ->latest()
            ->paginate();

        return new SessionStartCollection($sessionStarts);
    }

    public function store(
        SessionStartStoreRequest $request
    ): SessionStartResource {
        $this->authorize('create', SessionStart::class);

        $validated = $request->validated();

        $sessionStart = SessionStart::create($validated);

        return new SessionStartResource($sessionStart);
    }

    public function show(
        Request $request,
        SessionStart $sessionStart
    ): SessionStartResource {
        $this->authorize('view', $sessionStart);

        return new SessionStartResource($sessionStart);
    }

    public function update(
        SessionStartUpdateRequest $request,
        SessionStart $sessionStart
    ): SessionStartResource {
        $this->authorize('update', $sessionStart);

        $validated = $request->validated();

        $sessionStart->update($validated);

        return new SessionStartResource($sessionStart);
    }

    public function destroy(
        Request $request,
        SessionStart $sessionStart
    ): Response {
        $this->authorize('delete', $sessionStart);

        $sessionStart->delete();

        return response()->noContent();
    }
}
