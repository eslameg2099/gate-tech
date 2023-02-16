<x-layout :title="$building->name" :breadcrumbs="['dashboard.buildings.show', $building]">
    <div class="row">
        <div class="col-md-12">
            @include('dashboard.apartments.partials.filter')
        </div>
        <div class="col-md-6">
            @push('styles')
                <style>.min-h-195 {min-height: 195px;}</style>
            @endpush
            @component('dashboard::components.box')
                @slot('class', 'p-0')
                @slot('bodyClass', 'p-0 min-h-195')

                <table class="table table-striped table-middle">
                    <tbody>
                    <tr>
                        <th width="200">@lang('buildings.attributes.name')</th>
                        <td>{{ $building->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('buildings.attributes.user_id')</th>
                        <td>{{ $building->owner->name }}</td>
                    </tr>
                    <tr>
                        <th width="200">@lang('buildings.attributes.apartments_count')</th>
                        <td>{{ $building->apartments_count }}</td>
                    </tr>
                    </tbody>
                </table>

                @slot('footer')
                    @include('dashboard.buildings.partials.actions.edit')
                    @include('dashboard.buildings.partials.actions.delete')
                    @include('dashboard.buildings.partials.actions.restore')
                    @include('dashboard.buildings.partials.actions.forceDelete')
                @endslot
            @endcomponent
        </div>
        <div class="col-md-6">
            {{ BsForm::resource('apartments')->post(route('dashboard.apartments.store', ['building_id' => $building->id])) }}
            @component('dashboard::components.box')
                @slot('title', trans('apartments.actions.create'))

                @include('dashboard.apartments.partials.form')

                @slot('footer')
                    {{ BsForm::submit()->label(trans('apartments.actions.save')) }}
                @endslot
            @endcomponent
            {{ BsForm::close() }}
        </div>
        <div class="col-md-12">
            @include('dashboard.apartments.index')
        </div>
    </div>
</x-layout>
