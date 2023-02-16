@include('dashboard.errors')

<select2
        label="{{ __('customers.singular') }}"
        name="user_id"
        value="{{ old('user_id', $rent->user_id ?? null) }}"
        placeholder="{{ __('customers.select') }}"
        remote-url="{{ route('api.users.select', ['type' => \App\Models\User::CUSTOMER_TYPE]) }}"
></select2>

<div class="row">
    <div class="col">
        {{ BsForm::date('from') }}
    </div>
    <div class="col">
        {{ BsForm::date('to') }}
    </div>
</div>



{{ BsForm::price('amount')->required() }}

{{--{{ BsForm::checkbox('renewable')--}}
{{--    ->value(1)--}}
{{--    ->withoutDefault()--}}
{{--    ->checked(!! old('renewable', $rent->renewable ?? false)) }}--}}

