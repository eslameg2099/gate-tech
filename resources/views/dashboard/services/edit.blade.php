<x-layout :title="$service->name" :breadcrumbs="['dashboard.services.edit', $service]">
    {{ BsForm::resource('services')->putModel($service, route('dashboard.services.update', $service)) }}
    @component('dashboard::components.box')
        @slot('title', trans('services.actions.edit'))

        @include('dashboard.services.partials.form')

        @slot('footer')
            {{ BsForm::submit()->label(trans('services.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>