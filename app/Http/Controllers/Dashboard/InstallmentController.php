<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Installment;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InstallmentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param \App\Models\Installment $installment
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Installment $installment)
    {
        $transactions = $installment->transactions;

        return view('dashboard.installments.show', compact('installment', 'transactions'));
    }

    /**
     * @param \App\Models\Rent $rent
     * @return \Illuminate\Http\Response
     */
    public function payment(Rent $rent, Request $request)
    {
        $request->validate(['amount' => ['required', 'regex:/[0-9,]+/']]);

        auth()->user()->addTransaction($request->amount, null, $rent);

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
