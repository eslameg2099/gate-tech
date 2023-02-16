@can('viewAnyTrash', \App\Models\Building::class)
    <a href="{{ route('dashboard.buildings.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('buildings.trashed')
    </a>
@endcan
