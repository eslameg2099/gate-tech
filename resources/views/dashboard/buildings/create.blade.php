<x-layout :title="trans('buildings.actions.create')" :breadcrumbs="['dashboard.buildings.create']">
    {{ BsForm::resource('buildings')->post(route('dashboard.buildings.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('buildings.actions.create'))

        @include('dashboard.buildings.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('buildings.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>