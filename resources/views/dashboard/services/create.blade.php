<x-layout :title="trans('services.actions.create')" :breadcrumbs="['dashboard.services.create']">
    {{ BsForm::resource('services')->post(route('dashboard.services.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('services.actions.create'))

        @include('dashboard.services.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('services.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>