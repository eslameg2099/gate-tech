<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (
            in_array(request('type'), ['debit', 'credit'])
            && auth()->user()->isSupervisor()
            && ! auth()->user()->hasPermissionTo('manage.'.Str::plural(request('type')))
        ) {
            abort(403);
        }
        return view('dashboard.home');
    }
}
