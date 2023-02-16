@if(method_exists($service, 'trashed') && $service->trashed())
    @can('view', $service)
        <a href="{{ route('dashboard.services.trashed.show', $service) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $service)
        <a href="{{ route('dashboard.services.show', $service) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif