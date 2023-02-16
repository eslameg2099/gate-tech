<x-layout :title="$apartment->name" :breadcrumbs="['dashboard.apartments.show', $apartment]">
    <div class="row">
        <div class="col-md-12">
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('apartments.attributes.building_id')</th>
                        <td>
                            @include('dashboard.buildings.partials.actions.link', ['building' => $apartment->building])
                        </td>
                    </tr>
                    <tr>
                        <th width="200">@lang('apartments.attributes.number')</th>
                        <td>{{ $apartment->number }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('apartments.attributes.floor')</th>
                        <td>{{ $apartment->floor }}</td>
                    </tr>
                    @if($apartment->tenant)
                        <tr>
                            <th width="200">@lang('apartments.attributes.tenant')</th>
                            <td>
                                @include('dashboard.accounts.customers.partials.actions.link', ['customer' => $apartment->tenant->tenant])
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.apartments.partials.actions.edit')
                    @include('dashboard.apartments.partials.actions.delete')
                    @include('dashboard.apartments.partials.actions.restore')
                    @include('dashboard.apartments.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
        <div class="col-md-4">
            {{ BsForm::resource('rents')->post(route('dashboard.apartments.rents.store', $apartment)) }}
            @component('dashboard::components.box')
                @slot('title', trans('rents.actions.create'))

                @include('dashboard.rents.form')

                @slot('footer')
                    {{ BsForm::submit()->label(trans('rents.actions.save')) }}
                @endslot
            @endcomponent
            {{ BsForm::close() }}
        </div>
        <div class="col-md-8">
            @include('dashboard.rents.index')
        </div>
    </div>
</x-layout>
