<?php

namespace App\Http\Controllers\Api;

use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoanPaymentResource;
use App\Http\Resources\LoanPaymentCollection;
use App\Http\Requests\LoanPaymentStoreRequest;
use App\Http\Requests\LoanPaymentUpdateRequest;

class LoanPaymentController extends Controller
{
    public function index(Request $request): LoanPaymentCollection
    {
        $this->authorize('view-any', LoanPayment::class);

        $search = $request->get('search', '');

        $loanPayments = LoanPayment::search($search)
            ->latest()
            ->paginate();

        return new LoanPaymentCollection($loanPayments);
    }

    public function store(LoanPaymentStoreRequest $request): LoanPaymentResource
    {
        $this->authorize('create', LoanPayment::class);

        $validated = $request->validated();

        $loanPayment = LoanPayment::create($validated);

        return new LoanPaymentResource($loanPayment);
    }

    public function show(
        Request $request,
        LoanPayment $loanPayment
    ): LoanPaymentResource {
        $this->authorize('view', $loanPayment);

        return new LoanPaymentResource($loanPayment);
    }

    public function update(
        LoanPaymentUpdateRequest $request,
        LoanPayment $loanPayment
    ): LoanPaymentResource {
        $this->authorize('update', $loanPayment);

        $validated = $request->validated();

        $loanPayment->update($validated);

        return new LoanPaymentResource($loanPayment);
    }

    public function destroy(
        Request $request,
        LoanPayment $loanPayment
    ): Response {
        $this->authorize('delete', $loanPayment);

        $loanPayment->delete();

        return response()->noContent();
    }
}
