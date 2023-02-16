<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Service;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ServiceRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ServiceController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Service::class, 'service');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::filter()->latest()->paginate();

        return view('dashboard.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->all());

        flash()->success(trans('services.messages.created'));

        return redirect()->route('dashboard.services.show', $service);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        return view('dashboard.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return view('dashboard.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ServiceRequest $request
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $service->update($request->all());

        flash()->success(trans('services.messages.updated'));

        return redirect()->route('dashboard.services.show', $service);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Service $service
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $service->delete();

        flash()->success(trans('services.messages.deleted'));

        return redirect()->route('dashboard.services.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Service::class);

        $services = Service::onlyTrashed()->latest('deleted_at')->paginate();

        return view('dashboard.services.trashed', compact('services'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Service $service)
    {
        $this->authorize('viewTrash', $service);

        return view('dashboard.services.show', compact('service'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Service $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Service $service)
    {
        $this->authorize('restore', $service);

        $service->restore();

        flash()->success(trans('services.messages.restored'));

        return redirect()->route('dashboard.services.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Service $service
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Service $service)
    {
        $this->authorize('forceDelete', $service);

        $service->forceDelete();

        flash()->success(trans('services.messages.deleted'));

        return redirect()->route('dashboard.services.trashed');
    }
}
