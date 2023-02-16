@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.transactions.index'))
    @slot('name', trans('transactions.plural'))
    @slot('active', request()->routeIs('*transactions*'))
    @slot('icon', 'fas fa-dollar-sign')
@endcomponent
