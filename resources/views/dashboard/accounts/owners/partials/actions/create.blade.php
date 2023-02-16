@can('create', \App\Models\Owner::class)
    <a href="{{ route('dashboard.owners.create', request()->only('type')) }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('owners.actions.create')
    </a>
@endcan
