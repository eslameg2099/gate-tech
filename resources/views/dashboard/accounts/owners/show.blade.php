<x-layout :title="$owner->name" :breadcrumbs="['dashboard.owners.show', $owner]">
    @component('dashboard::components.box')
        @slot('bodyClass', 'p-0')

        <table class="table table-striped table-middle">
            <tbody>
            <tr>
                <th width="200">@lang('owners.attributes.name')</th>
                <td>{{ $owner->name }}</td>
            </tr>
            <tr>
                <th width="200">@lang('owners.attributes.email')</th>
                <td>{{ $owner->email }}</td>
            </tr>
            <tr>
                <th width="200">@lang('owners.attributes.phone')</th>
                <td>
                    @include('dashboard.accounts.owners.partials.flags.phone')
                </td>
            </tr>
            <tr>
                <th width="200">@lang('owners.attributes.avatar')</th>
                <td>
                    @if($owner->getFirstMedia('avatars'))
                        <file-preview :media="{{ $owner->getMediaResource('avatars') }}"></file-preview>
                    @else
                        <img src="{{ $owner->getAvatar() }}"
                             class="img img-size-64"
                             alt="{{ $owner->name }}">
                    @endif
                </td>
            </tr>
            </tbody>
        </table>

        @slot('footer')
            @include('dashboard.accounts.owners.partials.actions.edit')
            @include('dashboard.accounts.owners.partials.actions.delete')
            @include('dashboard.accounts.owners.partials.actions.restore')
            @include('dashboard.accounts.owners.partials.actions.forceDelete')
        @endslot
    @endcomponent
    @include('dashboard.buildings.partials.list', [
        'title' => __('buildings.plural'),
        'userId' => $owner->id,
    ])
</x-layout>
