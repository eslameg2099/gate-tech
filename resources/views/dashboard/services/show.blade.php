<x-layout :title="$service->name" :breadcrumbs="['dashboard.services.show', $service]">
    <div class="row">
        <div class="col-md-6">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('services.attributes.name')</th>
                        <td>{{ $service->name }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.services.partials.actions.edit')
                    @include('dashboard.services.partials.actions.delete')
                    @include('dashboard.services.partials.actions.restore')
                    @include('dashboard.services.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
    </div>
</x-layout>
