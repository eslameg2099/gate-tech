<x-layout :title="trans('buildings.plural')" :breadcrumbs="['dashboard.buildings.index']">
    @include('dashboard.buildings.partials.filter')
    @include('dashboard.buildings.partials.list')
</x-layout>
