<?php

namespace App\Http\Controllers;

use App\Models\Earning;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EarningStoreRequest;
use App\Http\Requests\EarningUpdateRequest;

class EarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Earning::class);

        $search = $request->get('search', '');

        $earnings = Earning::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.earnings.index', compact('earnings', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Earning::class);

        return view('app.earnings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EarningStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Earning::class);

        $validated = $request->validated();

        $earning = Earning::create($validated);

        return redirect()
            ->route('earnings.edit', $earning)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Earning $earning): View
    {
        $this->authorize('view', $earning);

        return view('app.earnings.show', compact('earning'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Earning $earning): View
    {
        $this->authorize('update', $earning);

        return view('app.earnings.edit', compact('earning'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EarningUpdateRequest $request,
        Earning $earning
    ): RedirectResponse {
        $this->authorize('update', $earning);

        $validated = $request->validated();

        $earning->update($validated);

        return redirect()
            ->route('earnings.edit', $earning)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Earning $earning
    ): RedirectResponse {
        $this->authorize('delete', $earning);

        $earning->delete();

        return redirect()
            ->route('earnings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
