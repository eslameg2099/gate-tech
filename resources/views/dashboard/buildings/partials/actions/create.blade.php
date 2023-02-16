@can('create', \App\Models\Building::class)
    <a href="{{ route('dashboard.buildings.create', ['user_id' => $userId ?? null]) }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('buildings.actions.create')
    </a>
@endcan
