<a href="#building-{{ $building->id }}-expenses-model"
   class="btn btn-outline-primary btn-sm"
   data-toggle="modal">
    {{ __('تقارير المصروفات') }}
</a>


<!-- Modal -->
<div class="modal fade" id="building-{{ $building->id }}-expenses-model" tabindex="-1" role="dialog"
     aria-labelledby="modal-title-{{ $building->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title-{{ $building->id }}">@lang('اختر التاريخ')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ BsForm::select('month')
                    ->label(__('التاريخ'))
                    ->options(__('months'))
                    ->attribute('form', "building-{$building->id}-expenses-form") }}

                {{ BsForm::select('year')
                    ->label(__('السنة'))
                    ->options(collect(range(1990, date('Y')))->map(fn($y) => [$y => $y])->reverse())
                    ->attribute('form', "building-{$building->id}-expenses-form") }}
            </div>
            <div class="modal-footer">
                <form id="building-{{ $building->id }}-expenses-form"
                      action="{{ route('dashboard.reports.monthly') }}" method="GET">
                    <input type="hidden" name="building_id" value="{{ $building->id }}">
                    <input type="hidden" name="type" value="expenses">
                    <button type="submit" class="btn btn-danger">
                        @lang('عرض التقارير')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
