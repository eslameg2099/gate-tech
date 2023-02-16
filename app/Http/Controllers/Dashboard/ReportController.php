<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Rent;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function monthly(Request $request)
    {
        $request->validate([
            'building_id' => ['nullable', 'exists:buildings,id'],
            'type' => ['nullable', 'in:expenses,deposits'],
            'month' => ['nullable', 'regex:/^(0[1-9]|1[012])$/'],
            'year' => ['nullable', 'regex:/(?:(?:19|20|21)[0-9]{2})/'],
        ], [], __('transactions.attributes'));

        /** @var Building $building */
        $building = Building::find($request->building_id);

        $transactions = Transaction::query()->filter();
        if ($request->type == 'deposits') {
            $transactions->where('model_type', Rent::class);
        } elseif ($request->type == 'expenses') {
            $transactions->whereNull('model_type');
        }
        $transactions = $transactions->get();

        $title = __('reports.plural');
        if ($building && $request->type && $request->month && $request->year) {
            $title = __('reports.titles.monthly-'.$request->type, [
                'building' => $building->name,
                'month' => __('months.'.$request->month),
                'year' => $request->year,
            ]);
            if (auth()->user()->isSupervisor() && $building->isNot(auth()->user()->building)) {
                abort(403);
            }
        }

        return view('dashboard.reports.monthly', get_defined_vars());
    }
    public function yearly(Request $request)
    {
        $request->validate([
            'wallet_id' => ['nullable', 'exists:wallets,id'],
            'type' => ['nullable', 'in:expenses,deposits'],
            'year' => ['nullable', 'regex:/(?:(?:19|20|21)[0-9]{2})/'],
        ], [], __('transactions.attributes'));

        $title = __('reports.plural');

        /** @var Building $building */
        /** @var Wallet $wallet */
        if ($request->wallet_id && $request->type) {
            $wallet = Wallet::find($request->wallet_id);
            $walletName = $wallet->model instanceof Building
                ? __('صندوق البناية')
                : ($wallet->model instanceof User ? __('صندوق المالك') : __('صندوق شركة الادارة'));

            $building = $wallet->model instanceof Building
                ? $wallet->model
                : ($wallet->model instanceof User ? $wallet->model->ownedBuildings()->first() : null);

            if (auth()->user()->isSupervisor() && $building->isNot(auth()->user()->building)) {
                abort(403);
            }

            $title = __('reports.titles.yearly-'.$request->type, [
                'building' => $building ? sprintf('%s (%s)', $building->name, $walletName) : __('شركة الادارة'),
                'year' => $request->year,
            ]);
        }

        $transactions = Transaction::query()->filter();

        if ($request->type == 'expenses') {
            $transactions->where('amount', '<', 0);
        }

        return view('dashboard.reports.yearly', get_defined_vars());
    }
}
