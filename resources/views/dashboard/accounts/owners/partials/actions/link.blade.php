@if($owner)
    @if(method_exists($owner, 'trashed') && $owner->trashed())
        <a href="{{ route('dashboard.owners.trashed.show', $owner) }}" class="text-decoration-none text-ellipsis">
            {{ $owner->name }}
        </a>
    @else
        <a href="{{ route('dashboard.owners.show', $owner) }}" class="text-decoration-none text-ellipsis">
            {{ $owner->name }}
        </a>
    @endif
@else
    ---
@endif