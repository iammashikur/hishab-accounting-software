<?php

namespace App\Http\Controllers\Api;

use App\Models\Expence;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenceResource;
use App\Http\Resources\ExpenceCollection;
use App\Http\Requests\ExpenceStoreRequest;
use App\Http\Requests\ExpenceUpdateRequest;

class ExpenceController extends Controller
{
    public function index(Request $request): ExpenceCollection
    {
        $this->authorize('view-any', Expence::class);

        $search = $request->get('search', '');

        $expences = Expence::search($search)
            ->latest()
            ->paginate();

        return new ExpenceCollection($expences);
    }

    public function store(ExpenceStoreRequest $request): ExpenceResource
    {
        $this->authorize('create', Expence::class);

        $validated = $request->validated();

        $expence = Expence::create($validated);

        return new ExpenceResource($expence);
    }

    public function show(Request $request, Expence $expence): ExpenceResource
    {
        $this->authorize('view', $expence);

        return new ExpenceResource($expence);
    }

    public function update(
        ExpenceUpdateRequest $request,
        Expence $expence
    ): ExpenceResource {
        $this->authorize('update', $expence);

        $validated = $request->validated();

        $expence->update($validated);

        return new ExpenceResource($expence);
    }

    public function destroy(Request $request, Expence $expence): Response
    {
        $this->authorize('delete', $expence);

        $expence->delete();

        return response()->noContent();
    }
}
