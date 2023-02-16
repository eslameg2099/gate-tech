@can('viewAnyTrash', \App\Models\Service::class)
    <a href="{{ route('dashboard.services.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('services.trashed')
    </a>
@endcan
