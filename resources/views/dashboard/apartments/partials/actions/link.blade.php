@if($apartment)
    @if(method_exists($apartment, 'trashed') && $apartment->trashed())
        <a href="{{ route('dashboard.apartments.trashed.show', $apartment) }}" class="text-decoration-none text-ellipsis">
            {{ $apartment->name }}
        </a>
    @else
        <a href="{{ route('dashboard.apartments.show', $apartment) }}" class="text-decoration-none text-ellipsis">
            {{ $apartment->name }}
        </a>
    @endif
@else
    ---
@endif