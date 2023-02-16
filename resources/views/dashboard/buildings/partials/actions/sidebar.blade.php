@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Building::class])
    @slot('url', route('dashboard.buildings.index'))
    @slot('name', trans('buildings.plural'))
    @slot('active', request()->routeIs('*buildings*'))
    @slot('icon', 'fas fa-building')
    @slot('tree', [
        [
            'name' => trans('buildings.actions.list'),
            'url' => route('dashboard.buildings.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Building::class],
            'active' => request()->routeIs('*buildings.index')
            || request()->routeIs('*buildings.show'),
        ],
        [
            'name' => trans('buildings.actions.create'),
            'url' => route('dashboard.buildings.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Building::class],
            'active' => request()->routeIs('*buildings.create'),
        ],
    ])
@endcomponent
