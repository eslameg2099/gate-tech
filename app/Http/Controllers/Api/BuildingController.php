<?php

namespace App\Http\Controllers\Api;

use App\Models\Building;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\BuildingResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BuildingController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the buildings.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $buildings = Building::filter()->when(auth()->user()->isSupervisor(), function (Builder $query) {
            $query->whereRelation('supervisors', 'id', auth()->id());
        })->simplePaginate();

        return BuildingResource::collection($buildings);
    }

    /**
     * Display the specified building.
     *
     * @param \App\Models\Building $building
     * @return \App\Http\Resources\BuildingResource
     */
    public function show(Building $building)
    {
        return new BuildingResource($building);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $buildings = Building::filter()->when(auth()->user()->isSupervisor(), function (Builder $query) {
            $query->whereRelation('supervisors', 'id', auth()->id());
        })->simplePaginate();

        return SelectResource::collection($buildings);
    }
}
