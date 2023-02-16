<x-layout :title="trans('owners.trashed')" :breadcrumbs="['dashboard.owners.trashed']">
    @include('dashboard.accounts.owners.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('owners.actions.list') ({{ count_formatted($owners->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <x-check-all-force-delete
                        type="{{ \App\Models\Owner::class }}"
                        :resource="trans('owners.plural')"></x-check-all-force-delete>
                <x-check-all-restore
                        type="{{ \App\Models\Owner::class }}"
                        :resource="trans('owners.plural')"></x-check-all-restore>
            </th>
        </tr>
        <tr>
            <th>
                <x-check-all></x-check-all>
            </th>
            <th>@lang('owners.attributes.name')</th>
            <th class="d-none d-md-table-cell">@lang('owners.attributes.email')</th>
            <th>@lang('owners.attributes.phone')</th>
            <th>@lang('owners.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
        </thead>
        <tbody>
        @forelse($owners as $owner)
            <tr>
                <td>
                    <x-check-all-item :model="$owner"></x-check-all-item>
                </td>
                <td>
                    <a href="{{ route('dashboard.owners.trashed.show', $owner) }}"
                       class="text-decoration-none text-ellipsis">
                            <span class="index-flag">
                            @include('dashboard.accounts.owners.partials.flags.svg')
                            </span>
                        <img src="{{ $owner->getAvatar() }}"
                             alt="Product 1"
                             class="img-circle img-size-32 mr-2">
                        {{ $owner->name }}
                    </a>
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $owner->email }}
                </td>
                <td>
                    @include('dashboard.accounts.owners.partials.flags.phone')
                </td>
                <td>{{ $owner->created_at->format('Y-m-d') }}</td>

                <td style="width: 160px">
                    @include('dashboard.accounts.owners.partials.actions.show')
                    @include('dashboard.accounts.owners.partials.actions.restore')
                    @include('dashboard.accounts.owners.partials.actions.forceDelete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('owners.empty')</td>
            </tr>
        @endforelse

        @if($owners->hasPages())
            @slot('footer')
                {{ $owners->links() }}
            @endslot
        @endif
    @endcomponent
</x-layout>
