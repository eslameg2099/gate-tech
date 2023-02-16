<x-layout :title="trans('services.plural')" :breadcrumbs="['dashboard.services.index']">
    @include('dashboard.services.partials.filter')

    @component('dashboard::components.table-box')
        @slot('title')
            @lang('services.actions.list') ({{ $services->total() }})
        @endslot

        <thead>
        <tr>
          <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\Service::class }}"
                        :resource="trans('services.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.services.partials.actions.create')
                    @include('dashboard.services.partials.actions.trashed')
                </div>
            </div>
          </th>
        </tr>
        <tr>
            <th style="width: 30px;" class="text-center">
              <x-check-all></x-check-all>
            </th>
            <th>@lang('services.attributes.name')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($services as $service)
            <tr>
                <td class="text-center">
                  <x-check-all-item :model="$service"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.services.show', $service) }}"
                       class="text-decoration-none text-ellipsis">
                        {{ $service->name }}
                    </a>
                </td>

                <td style="width: 160px">
                    @include('dashboard.services.partials.actions.show')
                    @include('dashboard.services.partials.actions.edit')
                    @include('dashboard.services.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('services.empty')</td>
            </tr>
        @endforelse

        @if($services->hasPages())
            @slot('footer')
                {{ $services->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
