{{ BsForm::resource('buildings')->get(url()->current()) }}
@component('dashboard::components.box')
    @slot('title', trans('بحث في التقارير'))

    <div class="row">
        <div class="col-md-3">
            {{ BsForm::select('building_id')
                    ->label(__('البناية'))
                    ->placeholder(__('اختر البناية'))
                    ->options(\App\Models\Building::when(auth()->user()->isSupervisor(), function ($query) {
            $query->whereRelation('supervisors', 'id', auth()->id());
        })->get()->pluck('name', 'id'))
                    ->value(request('building_id')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('type')
                    ->label(__('النوع'))
                    ->placeholder(__('اختر النوع'))
                    ->options([
                        'expenses' => __('reports.expenses'),
                        'deposits' => __('reports.deposits'),
                    ])
                    ->value(request('type')) }}
        </div>
        <div class="col-md-3">
            {{ BsForm::select('month')
                    ->label(__('التاريخ'))
                    ->placeholder(__('اختر التاريخ'))
                    ->options(__('months'))
                    ->value(request('month')) }}
        </div>
        <div class="col-md-3">
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
