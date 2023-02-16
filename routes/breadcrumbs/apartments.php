<?php

Breadcrumbs::for('dashboard.apartments.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('apartments.plural'), route('dashboard.apartments.index'));
});

Breadcrumbs::for('dashboard.apartments.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.apartments.index');
    $breadcrumb->push(trans('apartments.trashed'), route('dashboard.apartments.trashed'));
});

Breadcrumbs::for('dashboard.apartments.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.apartments.index');
    $breadcrumb->push(trans('apartments.actions.create'), route('dashboard.apartments.create'));
});

Breadcrumbs::for('dashboard.apartments.show', function ($breadcrumb, $apartment) {
    $breadcrumb->parent('dashboard.buildings.show', $apartment->building);
    $breadcrumb->push(
        __('apartments.singular').' '.$apartment->number,
        route('dashboard.apartments.show', $apartment)
    );
});

Breadcrumbs::for('dashboard.apartments.edit', function ($breadcrumb, $apartment) {
    $breadcrumb->parent('dashboard.apartments.show', $apartment);
    $breadcrumb->push(trans('apartments.actions.edit'), route('dashboard.apartments.edit', $apartment));
});
