<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LoanStoreRequest;
use App\Http\Requests\LoanUpdateRequest;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Loan::class);

        $search = $request->get('search', '');

        $loans = Loan::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.loans.index', compact('loans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Loan::class);

        return view('app.loans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Loan::class);

        $validated = $request->validated();

        $loan = Loan::create($validated);

        return redirect()
            ->route('loans.edit', $loan)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Loan $loan): View
    {
        $this->authorize('view', $loan);

        return view('app.loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Loan $loan): View
    {
        $this->authorize('update', $loan);

        return view('app.loans.edit', compact('loan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        LoanUpdateRequest $request,
        Loan $loan
    ): RedirectResponse {
        $this->authorize('update', $loan);

        $validated = $request->validated();

        $loan->update($validated);

        return redirect()
            ->route('loans.edit', $loan)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Loan $loan): RedirectResponse
    {
        $this->authorize('delete', $loan);

        $loan->delete();

        return redirect()
            ->route('loans.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
