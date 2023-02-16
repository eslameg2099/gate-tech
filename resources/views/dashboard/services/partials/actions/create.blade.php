@can('create', \App\Models\Service::class)
    <a href="{{ route('dashboard.services.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('services.actions.create')
    </a>
@endcan
