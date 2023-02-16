@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Service::class])
    @slot('url', route('dashboard.services.index'))
    @slot('name', trans('services.plural'))
    @slot('active', request()->routeIs('*services*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('services.actions.list'),
            'url' => route('dashboard.services.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Service::class],
            'active' => request()->routeIs('*services.index')
            || request()->routeIs('*services.show'),
        ],
        [
            'name' => trans('services.actions.create'),
            'url' => route('dashboard.services.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Service::class],
            'active' => request()->routeIs('*services.create'),
        ],
    ])
@endcomponent
