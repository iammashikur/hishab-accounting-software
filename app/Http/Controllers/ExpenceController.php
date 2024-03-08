<?php

namespace App\Http\Controllers;

use App\Models\Expence;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ExpenceStoreRequest;
use App\Http\Requests\ExpenceUpdateRequest;

class ExpenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Expence::class);

        $search = $request->get('search', '');

        $expences = Expence::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expences.index', compact('expences', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Expence::class);

        return view('app.expences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenceStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Expence::class);

        $validated = $request->validated();

        $expence = Expence::create($validated);

        return redirect()
            ->route('expences.edit', $expence)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Expence $expence): View
    {
        $this->authorize('view', $expence);

        return view('app.expences.show', compact('expence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Expence $expence): View
    {
        $this->authorize('update', $expence);

        return view('app.expences.edit', compact('expence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ExpenceUpdateRequest $request,
        Expence $expence
    ): RedirectResponse {
        $this->authorize('update', $expence);

        $validated = $request->validated();

        $expence->update($validated);

        return redirect()
            ->route('expences.edit', $expence)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Expence $expence
    ): RedirectResponse {
        $this->authorize('delete', $expence);

        $expence->delete();

        return redirect()
            ->route('expences.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
