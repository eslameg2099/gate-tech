<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Building;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\BuildingRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BuildingController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * BuildingController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Building::class, 'building');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buildings = Building::filter()->withCount([
            'apartments as rented_apartments_count' => function($query) {
                $query->has('tenant');
            }
        ])
            ->when(auth()->user()->isSupervisor(), function (Builder $query) {
                $query->whereRelation('supervisors', 'id', auth()->id());
            })->latest()->paginate();

        return view('dashboard.buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\BuildingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BuildingRequest $request)
    {
        $building = Building::create($request->all());

        flash()->success(trans('buildings.messages.created'));

        return redirect()->route('dashboard.buildings.show', $building);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Building $building
     * @return \Illuminate\Http\Response
     */
    public function show(Building $building)
    {
        if (auth()->user()->isSupervisor() && $building->isNot(auth()->user()->building)) {
            abort(403);
        }
        $apartments = $building->apartments()->filter()->get();

        return view('dashboard.buildings.show', compact('building', 'apartments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Building $building
     * @return \Illuminate\Http\Response
     */
    public function edit(Building $building)
    {
        return view('dashboard.buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\BuildingRequest $request
     * @param \App\Models\Building $building
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BuildingRequest $request, Building $building)
    {
        $building->update($request->all());

        flash()->success(trans('buildings.messages.updated'));

        return redirect()->route('dashboard.buildings.show', $building);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Building $building
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Building $building)
    {
        $building->delete();

        flash()->success(trans('buildings.messages.deleted'));

        return redirect()->route('dashboard.buildings.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Building::class);

        $buildings = Building::onlyTrashed()->latest('deleted_at')->paginate();

        return view('dashboard.buildings.trashed', compact('buildings'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Building $building
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Building $building)
    {
        $this->authorize('viewTrash', $building);

        return view('dashboard.buildings.show', compact('building'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Building $building
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Building $building)
    {
        $this->authorize('restore', $building);

        $building->restore();

        flash()->success(trans('buildings.messages.restored'));

        return redirect()->route('dashboard.buildings.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Building $building
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Building $building)
    {
        $this->authorize('forceDelete', $building);

        $building->forceDelete();

        flash()->success(trans('buildings.messages.deleted'));

        return redirect()->route('dashboard.buildings.trashed');
    }
}
