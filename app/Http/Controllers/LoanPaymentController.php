<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\View\View;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\LoanPaymentStoreRequest;
use App\Http\Requests\LoanPaymentUpdateRequest;

class LoanPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', LoanPayment::class);

        $search = $request->get('search', '');

        $loanPayments = LoanPayment::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.loan_payments.index',
            compact('loanPayments', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', LoanPayment::class);

        $loans = Loan::pluck('source', 'id');

        return view('app.loan_payments.create', compact('loans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoanPaymentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', LoanPayment::class);

        $validated = $request->validated();

        $loanPayment = LoanPayment::create($validated);

        return redirect()
            ->route('loan-payments.edit', $loanPayment)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, LoanPayment $loanPayment): View
    {
        $this->authorize('view', $loanPayment);

        return view('app.loan_payments.show', compact('loanPayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, LoanPayment $loanPayment): View
    {
        $this->authorize('update', $loanPayment);

        $loans = Loan::pluck('source', 'id');

        return view('app.loan_payments.edit', compact('loanPayment', 'loans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        LoanPaymentUpdateRequest $request,
        LoanPayment $loanPayment
    ): RedirectResponse {
        $this->authorize('update', $loanPayment);

        $validated = $request->validated();

        $loanPayment->update($validated);

        return redirect()
            ->route('loan-payments.edit', $loanPayment)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        LoanPayment $loanPayment
    ): RedirectResponse {
        $this->authorize('delete', $loanPayment);

        $loanPayment->delete();

        return redirect()
            ->route('loan-payments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
