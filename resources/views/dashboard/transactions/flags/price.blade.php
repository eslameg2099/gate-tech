@if($amount > 0)
    <span class="text-success"><bdi>{{ price($amount) }}</bdi></span>
@else
    <span class="text-danger"><bdi>{{ price($amount) }}</bdi></span>
@endif