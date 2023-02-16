<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Apartment $apartment
     * @throws \Illuminate\Validation\ValidationException
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Apartment $apartment)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d', 'after:from'],
            'amount' => ['required'],
        ], [], trans('rents.attributes'));

        DB::beginTransaction();
        if ($apartment->rents()->whereDateRange($request->from, $request->to)->exists()) {
            throw ValidationException::withMessages([
                'from' => [__('rents.errors.overlap')],
            ]);
        }

        /** @var Rent $rent */
        $rent = $apartment->rents()->create([
            'user_id' => $request->user_id,
            'from' => $request->from,
            'to' => $request->to,
            'amount' => $request->amount,
            'renewable' => $request->boolean('renewable'),
        ]);

        $from = $rent->from;
        foreach (range(1, $rent->from->diffInMonths($rent->to)) as $item) {
            $rent->installments()->create([
                'date' => $from,
                'amount' => $rent->amount,
            ]);

            $from = $from->addMonth();
        }

        DB::commit();

        flash(__('rents.messages.created'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Rent $rent
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment, Rent $rent)
    {
        $installments = $rent->installments()->get();

        return view('dashboard.rents.show', compact('rent', 'apartment', 'installments'));
    }

    /**
     * @param \App\Models\Rent $rent
     * @return \Illuminate\Http\Response
     */
    public function payment(Rent $rent, Request $request)
    {
        $request->validate([
            'amount' => ['required', 'regex:/[0-9,]+/'],
            'payment_method' => ['required', Rule::in(array_keys(__('transactions.payment_methods')))],
            'notes' => ['nullable', 'string'],
        ]);

        if ($rent->installments()->partiallyOrUnpaid()->doesntExist()) {
            throw ValidationException::withMessages([
                'apartment' => [__('لا يوجد مبالغ مستحقة لهذه الوحدة.')],
            ]);
        }

        auth()->user()->addTransaction($request->amount, [
            'reason' => $request->reason,
            'notes' => $request->notes,
            'payment_method' => $request->payment_method,
            'model_type' => $rent->getMorphClass(),
            'model_id' => $rent->getKey(),
        ]);

        flash(__('rents.messages.paid'));

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Rent $rent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Rent $rent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
