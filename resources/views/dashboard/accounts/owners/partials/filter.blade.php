{{ BsForm::resource('owners')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('owners.actions.filter'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::text('name')->value(request('name')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('email')->value(request('email')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::text('phone')->value(request('phone')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::number('perPage')
                ->value(request('perPage', 15))
                ->min(1)
                 ->label(trans('owners.perPage')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('owners.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
