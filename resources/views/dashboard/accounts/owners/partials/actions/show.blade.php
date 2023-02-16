@if(method_exists($owner, 'trashed') && $owner->trashed())
    @can('view', $owner)
        <a href="{{ route('dashboard.owners.trashed.show', $owner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $owner)
        <a href="{{ route('dashboard.owners.show', $owner) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif