<?php

namespace App\Http\Controllers\Api;

use App\Models\Loan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanPaymentResource;
use App\Http\Resources\LoanPaymentCollection;

class LoanLoanPaymentsController extends Controller
{
    public function index(Request $request, Loan $loan): LoanPaymentCollection
    {
        $this->authorize('view', $loan);

        $search = $request->get('search', '');

        $loanPayments = $loan
            ->loanPayments()
            ->search($search)
            ->latest()
            ->paginate();

        return new LoanPaymentCollection($loanPayments);
    }

    public function store(Request $request, Loan $loan): LoanPaymentResource
    {
        $this->authorize('create', LoanPayment::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        $loanPayment = $loan->loanPayments()->create($validated);

        return new LoanPaymentResource($loanPayment);
    }
}
