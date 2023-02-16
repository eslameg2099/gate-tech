@can('viewAnyTrash', \App\Models\Apartment::class)
    <a href="{{ route('dashboard.apartments.trashed') }}" class="btn btn-outline-danger btn-sm">
        <i class="fas fa fa-fw fa-trash"></i>
        @lang('apartments.trashed')
    </a>
@endcan
