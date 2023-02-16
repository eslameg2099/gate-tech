<x-layout :title="__('reports.plural')" bodyClass="sidebar-collapse" :breadcrumbs="['dashboard.reports.index']">
    @include('dashboard.reports.filter')
    @if(
        request()->filled('building_id') &&
        request()->filled('type') &&
        request()->filled('month') &&
        request()->filled('year')
    )
        @include('dashboard.reports.'.request('type'))
    @endif
</x-layout>
