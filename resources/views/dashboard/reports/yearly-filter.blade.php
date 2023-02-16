{{ BsForm::resource('buildings')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('بحث في التقارير'))

    <div class="row">
        <div class="col-md-4">
            {{ BsForm::select('wallet_id')
                    ->label(__('الصندوق'))
                    ->placeholder(__('اختر الصندوق'))
                    ->options(\App\Models\Wallet::groupedByBuilding())
                    ->value(request('wallet_id')) }}
        </div>
        <div class="col-md-4">
            {{ BsForm::select('type')
                    ->label(__('النوع'))
                    ->placeholder(__('اختر النوع'))
                    ->options([
                        'expenses' => __('reports.expenses'),
                        'deposits' => __('reports.deposits'),
                    ])
                    ->value(request('type')) }}
        </div>
        <div class="col-md-4">
            {{ BsForm::select('year')
                    ->label(__('السنة'))
                    ->placeholder(__('اختر السنة'))
                    ->options(collect(range(1990, date('Y')))->mapWithKeys(fn($y) => [$y => $y])->reverse())
                    ->value(request('year')) }}
        </div>
    </div>

    @slot('footer')
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa fa-fw fa-filter"></i>
            @lang('buildings.actions.filter')
        </button>
    @endslot
@endcomponent
{{ BsForm::close() }}
