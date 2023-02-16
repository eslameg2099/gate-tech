<x-layout :title="trans('apartments.trashed')" :breadcrumbs="['dashboard.apartments.trashed']">
    @include('dashboard.apartments.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('apartments.actions.list') ({{ $apartments->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
              <x-check-all-force-delete
                      type="{{ \App\Models\Apartment::class }}"
                      :resource="trans('apartments.plural')"></x-check-all-force-delete>
              <x-check-all-restore
                      type="{{ \App\Models\Apartment::class }}"
                      :resource="trans('apartments.plural')"></x-check-all-restore>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('apartments.attributes.number')</th>
            <th>@lang('apartments.attributes.floor')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($apartments as $apartment)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$apartment"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.apartments.trashed.show', $apartment) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $apartment->number }}
                    </a>
                </td>
                <td>{{ $apartment->floor }}</td>

                <td style="width: 160px">
                    @include('dashboard.apartments.partials.actions.show')
                    @include('dashboard.apartments.partials.actions.restore')
                    @include('dashboard.apartments.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('apartments.empty')</td>
            </tr>
        @endforelse

        @if($apartments->hasPages())
            @slot('footer')
                {{ $apartments->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
