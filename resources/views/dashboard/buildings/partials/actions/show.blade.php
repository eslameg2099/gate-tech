@if(method_exists($building, 'trashed') && $building->trashed())
    @can('view', $building)
        <a href="{{ route('dashboard.buildings.trashed.show', $building) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@else
    @can('view', $building)
        <a href="{{ route('dashboard.buildings.show', $building) }}" class="btn btn-outline-dark btn-sm">
            <i class="fas fa fa-fw fa-eye"></i>
        </a>
    @endcan
@endif