<?php

namespace App\Http\Controllers\Api;

use App\Models\Earning;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\EarningResource;
use App\Http\Resources\EarningCollection;
use App\Http\Requests\EarningStoreRequest;
use App\Http\Requests\EarningUpdateRequest;

class EarningController extends Controller
{
    public function index(Request $request): EarningCollection
    {
        $this->authorize('view-any', Earning::class);

        $search = $request->get('search', '');

        $earnings = Earning::search($search)
            ->latest()
            ->paginate();

        return new EarningCollection($earnings);
    }

    public function store(EarningStoreRequest $request): EarningResource
    {
        $this->authorize('create', Earning::class);

        $validated = $request->validated();

        $earning = Earning::create($validated);

        return new EarningResource($earning);
    }

    public function show(Request $request, Earning $earning): EarningResource
    {
        $this->authorize('view', $earning);

        return new EarningResource($earning);
    }

    public function update(
        EarningUpdateRequest $request,
        Earning $earning
    ): EarningResource {
        $this->authorize('update', $earning);

        $validated = $request->validated();

        $earning->update($validated);

        return new EarningResource($earning);
    }

    public function destroy(Request $request, Earning $earning): Response
    {
        $this->authorize('delete', $earning);

        $earning->delete();

        return response()->noContent();
    }
}
