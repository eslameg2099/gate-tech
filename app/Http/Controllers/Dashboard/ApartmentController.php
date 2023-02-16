<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Apartment;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ApartmentRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApartmentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ApartmentController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Apartment::class, 'apartment');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::filter()->latest()->paginate();

        
        return view('dashboard.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ApartmentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ApartmentRequest $request)
    {
        $apartment = Apartment::create($request->all());

        flash()->success(trans('apartments.messages.created'));

        return redirect()->route('dashboard.buildings.show', $apartment->building);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $rents = $apartment->rents()->latest()->paginate();

        return view('dashboard.apartments.show', compact('apartment', 'rents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return view('dashboard.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ApartmentRequest $request
     * @param \App\Models\Apartment $apartment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ApartmentRequest $request, Apartment $apartment)
    {
        $apartment->update($request->all());

        flash()->success(trans('apartments.messages.updated'));

        return redirect()->route('dashboard.apartments.show', $apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Apartment $apartment
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Apartment $apartment)
    {
        $building = $apartment->building;

        $apartment->delete();

        flash()->success(trans('apartments.messages.deleted'));

        return redirect()->route('dashboard.buildings.show', $building);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Apartment::class);

        $apartments = Apartment::onlyTrashed()->latest('deleted_at')->paginate();

        return view('dashboard.apartments.trashed', compact('apartments'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Apartment $apartment
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Apartment $apartment)
    {
        $this->authorize('viewTrash', $apartment);

        return view('dashboard.apartments.show', compact('apartment'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Apartment $apartment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Apartment $apartment)
    {
        $this->authorize('restore', $apartment);

        $apartment->restore();

        flash()->success(trans('apartments.messages.restored'));

        return redirect()->route('dashboard.apartments.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Apartment $apartment
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Apartment $apartment)
    {
        $this->authorize('forceDelete', $apartment);

        $apartment->forceDelete();

        flash()->success(trans('apartments.messages.deleted'));

        return redirect()->route('dashboard.apartments.trashed');
    }
}
