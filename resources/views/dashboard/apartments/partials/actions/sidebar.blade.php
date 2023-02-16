@component('dashboard::components.sidebarItem')
    @slot('can', ['ability' => 'viewAny', 'model' => \App\Models\Apartment::class])
    @slot('url', route('dashboard.apartments.index'))
    @slot('name', trans('apartments.plural'))
    @slot('active', request()->routeIs('*apartments*'))
    @slot('icon', 'fas fa-th')
    @slot('tree', [
        [
            'name' => trans('apartments.actions.list'),
            'url' => route('dashboard.apartments.index'),
            'can' => ['ability' => 'viewAny', 'model' => \App\Models\Apartment::class],
            'active' => request()->routeIs('*apartments.index')
            || request()->routeIs('*apartments.show'),
        ],
        [
            'name' => trans('apartments.actions.create'),
            'url' => route('dashboard.apartments.create'),
            'can' => ['ability' => 'create', 'model' => \App\Models\Apartment::class],
            'active' => request()->routeIs('*apartments.create'),
        ],
    ])
@endcomponent
