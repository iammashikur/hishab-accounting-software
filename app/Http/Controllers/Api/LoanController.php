<?php

namespace App\Http\Controllers\Api;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\LoanResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanCollection;
use App\Http\Requests\LoanStoreRequest;
use App\Http\Requests\LoanUpdateRequest;

class LoanController extends Controller
{
    public function index(Request $request): LoanCollection
    {
        $this->authorize('view-any', Loan::class);

        $search = $request->get('search', '');

        $loans = Loan::search($search)
            ->latest()
            ->paginate();

        return new LoanCollection($loans);
    }

    public function store(LoanStoreRequest $request): LoanResource
    {
        $this->authorize('create', Loan::class);

        $validated = $request->validated();

        $loan = Loan::create($validated);

        return new LoanResource($loan);
    }

    public function show(Request $request, Loan $loan): LoanResource
    {
        $this->authorize('view', $loan);

        return new LoanResource($loan);
    }

    public function update(LoanUpdateRequest $request, Loan $loan): LoanResource
    {
        $this->authorize('update', $loan);

        $validated = $request->validated();

        $loan->update($validated);

        return new LoanResource($loan);
    }

    public function destroy(Request $request, Loan $loan): Response
    {
        $this->authorize('delete', $loan);

        $loan->delete();

        return response()->noContent();
    }
}
