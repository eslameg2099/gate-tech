@if($building)
    @if(method_exists($building, 'trashed') && $building->trashed())
        <a href="{{ route('dashboard.buildings.trashed.show', $building) }}" class="text-decoration-none text-ellipsis">
            {{ $building->name }}
        </a>
    @else
        <a href="{{ route('dashboard.buildings.show', $building) }}" class="text-decoration-none text-ellipsis">
            {{ $building->name }}
        </a>
    @endif
@else
    ---
@endif