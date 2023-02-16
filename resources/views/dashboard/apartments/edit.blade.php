<x-layout :title="$apartment->name" :breadcrumbs="['dashboard.apartments.edit', $apartment]">
    {{ BsForm::resource('apartments')->putModel($apartment, route('dashboard.apartments.update', [$apartment, 'building_id' => $apartment->building->id])) }}
    @component('dashboard::components.box')
        @slot('title', trans('apartments.actions.edit'))

        @include('dashboard.apartments.partials.form', ['floors' => $apartment->building->floors])

        @slot('footer')
            {{ BsForm::submit()->label(trans('apartments.actions.save')) }}
        @endslot
    @endcomponent
    {{ BsForm::close() }}
</x-layout>