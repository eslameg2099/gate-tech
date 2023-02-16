<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Owner;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\OwnerRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OwnerController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * OwnerController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Owner::class, 'owner');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::filter()->latest()->paginate();

        return view('dashboard.accounts.owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.accounts.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\OwnerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OwnerRequest $request)
    {
        $owner = Owner::create($request->allWithHashedPassword());

        $owner->setType($request->type);

        $owner->addAllMediaFromTokens();

        flash()->success(trans('owners.messages.created'));

        return redirect()->route('dashboard.owners.show', $owner);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        $buildings = $owner->ownedBuildings()->withCount([
            'apartments as rented_apartments_count' => function($query) {
                $query->has('tenant');
            }
        ])->filter()->paginate();

        return view('dashboard.accounts.owners.show', compact('owner', 'buildings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $owner)
    {
        return view('dashboard.accounts.owners.edit', compact('owner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\OwnerRequest $request
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OwnerRequest $request, Owner $owner)
    {
        $owner->update($request->allWithHashedPassword());

        $owner->setType($request->type);

        $owner->addAllMediaFromTokens();

        flash()->success(trans('owners.messages.updated'));

        return redirect()->route('dashboard.owners.show', $owner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Owner $owner
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();

        flash()->success(trans('owners.messages.deleted'));

        return redirect()->route('dashboard.owners.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Owner::class);

        $owners = Owner::onlyTrashed()->latest('deleted_at')->paginate();

        return view('dashboard.accounts.owners.trashed', compact('owners'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Owner $owner)
    {
        $this->authorize('viewTrash', $owner);

        return view('dashboard.accounts.owners.show', compact('owner'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Owner $owner
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Owner $owner)
    {
        $this->authorize('restore', $owner);

        $owner->restore();

        flash()->success(trans('owners.messages.restored'));

        return redirect()->route('dashboard.owners.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Owner $owner
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Owner $owner)
    {
        $this->authorize('forceDelete', $owner);

        $owner->forceDelete();

        flash()->success(trans('owners.messages.deleted'));

        return redirect()->route('dashboard.owners.trashed');
    }
}
