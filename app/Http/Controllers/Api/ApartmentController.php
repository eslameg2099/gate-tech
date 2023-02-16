<?php

namespace App\Http\Controllers\Api;

use App\Models\Apartment;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\ApartmentResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApartmentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the apartments.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $apartments = Apartment::filter()->simplePaginate();

        return ApartmentResource::collection($apartments);
    }

    /**
     * Display the specified apartment.
     *
     * @param \App\Models\Apartment $apartment
     * @return \App\Http\Resources\ApartmentResource
     */
    public function show(Apartment $apartment)
    {
        $apartment->load('tenant.lastPartiallyOrPaidInstallment');

        return new ApartmentResource($apartment);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $apartments = Apartment::filter()->simplePaginate();

        return SelectResource::collection($apartments);
    }
}
