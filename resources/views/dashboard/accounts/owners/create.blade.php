<x-layout :title="trans('owners.actions.create')" :breadcrumbs="['dashboard.owners.create']">
    {{ BsForm::resource('owners')->post(route('dashboard.owners.store')) }}
    @component('dashboard::components.box')
        @slot('title', trans('owners.actions.create'))

        @include('dashboard.accounts.owners.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('owners.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>