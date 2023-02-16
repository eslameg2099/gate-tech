<x-layout :title="trans('apartments.actions.create')" :breadcrumbs="['dashboard.apartments.create']">
    {{ BsForm::resource('apartments')->post(route('dashboard.apartments.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('apartments.actions.create'))

        @include('dashboard.apartments.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('apartments.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>