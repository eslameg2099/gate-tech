@if(method_exists($apartment, 'trashed') && $apartment->trashed())
    @can('view', $apartment)
        <a href="{{ route('dashboard.apartments.trashed.show', $apartment) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $apartment)
        <a href="{{ route('dashboard.apartments.show', $apartment) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif