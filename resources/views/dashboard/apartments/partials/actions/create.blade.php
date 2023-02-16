@can('create', \App\Models\Apartment::class)
    <a href="{{ route('dashboard.apartments.create') }}" class="btn btn-outline-success btn-sm">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('apartments.actions.create')
    </a>
@endcan
