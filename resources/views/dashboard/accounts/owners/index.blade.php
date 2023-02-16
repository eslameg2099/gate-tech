<x-layout :title="trans('owners.plural')" :breadcrumbs="['dashboard.owners.index']">
    @include('dashboard.accounts.owners.partials.filter')

    @component('dashboard::components.table-box')

        @slot('title')
            @lang('owners.actions.list') ({{ count_formatted($owners->total()) }})
        @endslot

        <thead>
        <tr>
            <th colspan="100">
                <div class="d-flex">
                    <x-check-all-delete
                            type="{{ \App\Models\Owner::class }}"
                            :resource="trans('owners.plural')"></x-check-all-delete>

                    <div class="ml-2 d-flex justify-content-between flex-grow-1">
                        @include('dashboard.accounts.owners.partials.actions.create')
                        @include('dashboard.accounts.owners.partials.actions.trashed')
                    </div>
                </div>
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
                    <a href="{{ route('dashboard.owners.show', $owner) }}"
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
                    @include('dashboard.accounts.owners.partials.actions.edit')
                    @include('dashboard.accounts.owners.partials.actions.delete')
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
