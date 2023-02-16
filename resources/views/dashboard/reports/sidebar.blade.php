@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.reports.monthly'))
    @slot('name', trans('التقارير الشهرية'))
    @slot('active', request()->routeIs('*reports.monthly*'))
    @slot('icon', 'fas fa-file')
@endcomponent
@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.reports.yearly'))
    @slot('name', trans('التقارير السنوية'))
    @slot('active', request()->routeIs('*reports.yearly*'))
    @slot('icon', 'fas fa-file')
@endcomponent
