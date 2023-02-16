@include('dashboard.errors')

@if(isset($apartmentSelect) && $apartmentSelect)
<apartment-select></apartment-select>
@endif

@if(isset($rent))
{{ BsForm::price('amount')->value(old('amount', optional($rent->installments()->partiallyOrUnpaid()->first())->remaining_amount))->required() }}
@else
    {{ BsForm::price('amount')->required() }}
@endif

{{ BsForm::select('payment_method')->options(__('transactions.payment_methods')) }}

@if(isset($reason) && $reason)
    {{ BsForm::text('reason') }}
@endif

{{ BsForm::textarea('notes')->rows(3) }}


