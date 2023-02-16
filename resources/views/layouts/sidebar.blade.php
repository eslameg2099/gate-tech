@component('dashboard::components.sidebarItem')
    @slot('url', route('dashboard.home'))
    @slot('name', trans('dashboard.home'))
    @slot('icon', 'fas fa-tachometer-alt')
    @slot('active', request()->routeIs('dashboard.home'))
@endcomponent

@include('dashboard.accounts.sidebar')
@include('dashboard.buildings.partials.actions.sidebar')
@include('dashboard.services.partials.actions.sidebar')
@include('dashboard.transactions.partials.actions.sidebar')
@include('dashboard.reports.sidebar')
{{-- The sidebar of generated crud will set here: Don't remove this line --}}
{{--@include('dashboard.feedback.partials.actions.sidebar')--}}
@include('dashboard.settings.sidebar')
