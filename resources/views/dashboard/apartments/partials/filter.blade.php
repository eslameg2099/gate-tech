{{ BsForm::resource('apartments')->get(url()->current()) }}
@component('dashboard::components.box', ['collapsed' => true])
    @slot('title', trans('apartments.filter'))

    <div class="row">
        <div class="col-md-6">
            {{ BsForm::text('number')->value(request('number')) }}
        </div>
        <div class="col-md-6">
            {{ BsForm::text('floor')->value(request('floor')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('apartments.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
