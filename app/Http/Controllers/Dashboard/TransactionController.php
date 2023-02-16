<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Rent;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::filter()
            ->when(auth()->user()->isSupervisor(), function (Builder $query) {
                $query->whereHasMorph('model', [Rent::class], function (Builder $query) {
                   $query->whereRelation('apartment', 'building_id', auth()->user()->building_id);
                });
            })
            ->latest()
            ->paginate();

        return view('dashboard.transactions.index', compact('transactions'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'regex:/[0-9,]+/'],
            'payment_method' => ['required', Rule::in(array_keys(__('transactions.payment_methods')))],
            'notes' => ['nullable', 'string'],
            'reason' => ['nullable', 'string'],
            'check_number' => ['nullable'],
            'apartment_id' => ['nullable', 'exists:apartments,id'],
            'wallet_id' => ['required', 'exists:wallets,id'],
            'service_id' => ['nullable', 'exists:services,id'],
        ]);

        $modelType = null;
        $modelId = null;
        if ($request->apartment_id) {
            $apartment = Apartment::find($request->apartment_id);

            //if (! ($rent = $apartment->tenant) || $rent->installments()->partiallyOrUnpaid()->doesntExist()) {
            //    throw ValidationException::withMessages([
            //        'apartment' => [__('لا يوجد مبالغ مستحقة لهذه الوحدة.')],
            //    ]);
            //}

            if ($rent = $apartment->tenant) {
                $modelType = $rent->getMorphClass();
                $modelId = $rent->getKey();
            }
        }

        $amount = str_replace(',', '', $request->amount);
        if ($request->type == 'debit') {
            $amount = $amount * -1;
        }

        $transaction = auth()->user()->addTransaction($amount, [
            'wallet_id' => $request->wallet_id,
            'date' => $request->date,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'check_number' => $request->check_number ?: null,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'service_id' => $request->service_id ?: null,
        ]);

        $transaction->addAllMediaFromTokens($request->check_image);

        flash(__('rents.messages.paid'));

        return redirect()->route('dashboard.transactions.show', $transaction);
    }

    public function show(Transaction $transaction)
    {
        if (auth()->user()->isSupervisor()) {
            if ($transaction->model_type !== Rent::class) {
                abort(403);
            }
            if ($transaction->model->apartment->building_id !== auth()->user()->building_id) {
                abort(403);
            }
        }
        return view('dashboard.transactions.show', compact('transaction'));
    }
}
