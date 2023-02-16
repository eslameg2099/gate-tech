{{ BsForm::resource('transactions')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('transactions.filter'))

    <div class="row">
        <div class="col-md-4 d-flex align-items-end">
            {{ BsForm::radio('type')
                ->value('all')
                ->checked(request('type') == 'all' || ! request('type'))
                 ->label(trans('transactions.all')) }}
        </div>
        <div class="col-md-4 d-flex align-items-end">
            {{ BsForm::radio('type')
                ->value('credit')
                ->checked(request('type') == 'credit')
                 ->label(trans('transactions.credit')) }}
        </div>
        <div class="col-md-4 d-flex align-items-end">
            {{ BsForm::radio('type')
                ->value('debit')
                ->checked(request('type') == 'debit')
                 ->label(trans('transactions.debit')) }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('reason')->value(request('reason')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('payment_method')
                ->placeholder(__('transactions.all'))
                ->options(__('transactions.payment_methods'))
                ->value(request('payment_method')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('wallet_id')
                ->placeholder(__('transactions.all'))
                ->options(\App\Models\Wallet::all()->pluck('name', 'id'))
                ->value(request('wallet_id')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('transactions.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('transactions.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
