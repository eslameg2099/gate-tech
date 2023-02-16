<x-layout :title="trans('buildings.trashed')" :breadcrumbs="['dashboard.buildings.trashed']">
    @include('dashboard.buildings.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('buildings.actions.list') ({{ $buildings->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
              <x-check-all-force-delete
                      type="{{ \App\Models\Building::class }}"
                      :resource="trans('buildings.plural')"></x-check-all-force-delete>
              <x-check-all-restore
                      type="{{ \App\Models\Building::class }}"
                      :resource="trans('buildings.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('buildings.attributes.name')</th>
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
                    <a href="{{ route('dashboard.buildings.trashed.show', $building) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $building->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.buildings.partials.actions.show')
                    @include('dashboard.buildings.partials.actions.restore')
                    @include('dashboard.buildings.partials.actions.forceDelete')
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
</x-layout>
