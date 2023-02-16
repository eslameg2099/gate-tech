<?php /** @var \App\Models\Rent[]|\Illuminate\Pagination\LengthAwarePaginator $rents */ ?>
<?php /** @var \App\Models\Rent $rent */ ?>
@component('dashboard::components.table-box')
    @slot('title')
        @lang('rents.plural') ({{ $rents->total() }})
    @endslot

    <thead>
    <tr>
        <th>@lang('rents.attributes.user_id')</th>
        <th>@lang('rents.attributes.period')</th>
{{--        <th>@lang('rents.attributes.renewable')</th>--}}
        <th>@lang('rents.attributes.amount')</th>
    </tr>
    </thead>
    <tbody>
    @forelse($rents as $rent)
        <tr>
            <td>
                <a href="{{ route('dashboard.apartments.rents.show', [$rent->apartment, $rent]) }}">
                    {{ $rent->tenant->name }}
                </a>
            </td>
            <td>{{ $rent->from->toDateString() }} ~ {{ $rent->to->toDateString() }}</td>
{{--            <td><x-boolean is="{{ $rent->renewable }}"></x-boolean></td>--}}
            <td>{{ price($rent->amount) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="100" class="text-center">@lang('rents.empty')</td>
        </tr>
    @endforelse
@endcomponent
