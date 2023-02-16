@can('viewAnyTrash', \App\Models\Owner::class)
    <a href="{{ route('dashboard.owners.trashed', request()->only('type')) }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('owners.trashed')
    </a>
@endcan
