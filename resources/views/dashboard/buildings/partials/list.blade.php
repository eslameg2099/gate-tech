@component('dashboard::components.table-box')
    @slot('title')
        {{ $title ?? __('buildings.actions.list') }} ({{ $buildings->total() }})
    @endslot

    <thead>
    <tr>
        <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\Building::class }}"
                        :resource="trans('buildings.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.buildings.partials.actions.create')
                    @include('dashboard.buildings.partials.actions.trashed')
                </div>
            </div>
        </th>
    </tr>
    <tr>
        <th style="width: 30px;" class="text-center">
            <x-check-all></x-check-all>
        </th>
        <th>@lang('buildings.attributes.name')</th>
        <th>@lang('buildings.attributes.user_id')</th>
        <th>@lang('buildings.attributes.rented_apartments_count')</th>
        <th>@lang('buildings.attributes.apartments_count')</th>
        <th style="width: 160px">...</th>
    </tr>
    </thead>
    <tbody>
    @forelse($buildings as $building)
        <tr>
            <td class="text-center">
                <x-check-all-item :model="$building"></x-check-all-item>
            </td>
            <td>
                <a href="{{ route('dashboard.buildings.show', $building) }}"
                   class="text-decoration-none text-ellipsis">
                    {{ $building->name }}
                </a>
            </td>
            <td>{{ $building->owner->name }}</td>
            <td>{{ $building->rented_apartments_count }}</td>
            <td>{{ $building->apartments_count }}</td>

            <td style="width: 160px">
                @include('dashboard.buildings.partials.actions.show')
                @include('dashboard.buildings.partials.actions.edit')
                @include('dashboard.buildings.partials.actions.delete')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100" class="text-center">@lang('buildings.empty')</td>
        </tr>
    @endforelse

    @if($buildings->hasPages())
        @slot('footer')
            {{ $buildings->links() }}
        @endslot
    @endif
@endcomponent