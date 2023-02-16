@if($service)
    @if(method_exists($service, 'trashed') && $service->trashed())
        <a href="{{ route('dashboard.services.trashed.show', $service) }}" class="text-decoration-none text-ellipsis">
            {{ $service->name }}
        </a>
    @else
        <a href="{{ route('dashboard.services.show', $service) }}" class="text-decoration-none text-ellipsis">
            {{ $service->name }}
        </a>
    @endif
@else
    ---
@endif