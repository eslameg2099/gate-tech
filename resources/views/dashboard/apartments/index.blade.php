@component('dashboard::components.table-box')
    @slot('title')
        @lang('apartments.plural') ({{ $apartments->count() }})
    @endslot

    <thead>
    <tr>
        <th colspan="100">
            <div class="d-flex">
                <x-check-all-delete
                        type="{{ \App\Models\Apartment::class }}"
                        :resource="trans('apartments.plural')"></x-check-all-delete>

                <div class="ml-2 d-flex justify-content-between flex-grow-1">
                    @include('dashboard.apartments.partials.actions.trashed')
                </div>
            </div>
        </th>
    </tr>
    <tr>

        <th>@lang('apartments.attributes.floor')</th>
        <th>
            <div class="d-inline-block mr-2">
                <x-check-all></x-check-all>
            </div>
            @lang('apartments.plural')
        </th>
    </tr>
    </thead>
    <tbody>
    @forelse($apartments->groupBy('floor') as $floor => $floorApartments)
        <tr>
            <td>{{ __('apartments.attributes.floor') }} {{ $floor }}</td>
            <td>
                <table class="table">
                    <tr>
                        <th></th>
                        <th>@lang('apartments.attributes.number')</th>
                        <th>@lang('apartments.attributes.tenant')</th>
                        <th>@lang('rents.attributes.to')</th>
                        <th style="width: 160px">...</th>
                    </tr>
                    @foreach($floorApartments as $apartment)
                        <tr>
                            <td class="text-center" style="width: 50px;">
                                <x-check-all-item :model="$apartment"></x-check-all-item>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.apartments.show', $apartment) }}"
                                   class="text-decoration-none text-ellipsis">
                                    {{ __('apartments.singular') }} {{ $apartment->number }}
                                </a>
                            </td>
                            <td>
                                @if($apartment->tenant)
                                    @include('dashboard.accounts.customers.partials.actions.link', ['customer' => $apartment->tenant->tenant])
                                @else
                                    ---
                                @endif
                            </td>
                            <td>
                                @if($apartment->tenant)
                                    {{ $apartment->tenant->to->toDateString() }}
                                    @if($apartment->tenant->renewable)
                                        ({{ __('rents.attributes.renewable') }})
                                    @endif
                                @else
                                    ---
                                @endif
                            </td>
                            <td style="width: 160px">
                                @include('dashboard.apartments.partials.actions.show')
                                @include('dashboard.apartments.partials.actions.edit')
                                @include('dashboard.apartments.partials.actions.delete')
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="100" class="text-center">@lang('apartments.empty')</td>
        </tr>
    @endforelse
@endcomponent
