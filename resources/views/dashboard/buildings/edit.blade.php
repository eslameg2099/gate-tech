<x-layout :title="$building->name" :breadcrumbs="['dashboard.buildings.edit', $building]">
    {{ BsForm::resource('buildings')->putModel($building, route('dashboard.buildings.update', $building)) }}
    @component('dashboard::components.box')
        @slot('title', trans('buildings.actions.edit'))

        @include('dashboard.buildings.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('buildings.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>