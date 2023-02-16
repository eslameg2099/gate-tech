<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WalletResource;
use App\Models\Building;
use App\Models\Service;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Controller;
use App\Http\Resources\SelectResource;
use App\Http\Resources\ServiceResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WalletController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $services = Service::filter()->when(auth()->user()->isSupervisor(), function (Builder $query) {
            $query->where('model_type', Building::class);
            $query->where('model_id', auth()->user()->building_id);
        })->simplePaginate();

        return ServiceResource::collection($services);
    }

    /**
     * Display the specified service.
     *
     * @param \App\Models\Service $service
     * @return \App\Http\Resources\ServiceResource
     */
    public function show(Service $service)
    {
        return new ServiceResource($service);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $wallets = Wallet::filter()->when(auth()->user()->isSupervisor(), function (Builder $query) {
            $query->where(function ($query) {
                $query->where('model_type', Building::class);
                $query->where('model_id', auth()->user()->building_id);
            });
            $query->orWhere(function ($query) {
                $query->where('model_type', User::class);
                $query->where('model_id', auth()->user()->building->user_id);
            });
        })->latest()->get();

        return WalletResource::collection($wallets);
    }
}
