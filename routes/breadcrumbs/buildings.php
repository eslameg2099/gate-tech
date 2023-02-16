<?php

Breadcrumbs::for('dashboard.buildings.index', function ($breadcrumb) {
    $breadcrumb->push(trans('buildings.plural'), route('dashboard.buildings.index'));
});

Breadcrumbs::for('dashboard.buildings.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.buildings.index');
    $breadcrumb->push(trans('buildings.trashed'), route('dashboard.buildings.trashed'));
});

Breadcrumbs::for('dashboard.buildings.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.buildings.index');
    $breadcrumb->push(trans('buildings.actions.create'), route('dashboard.buildings.create'));
});

Breadcrumbs::for('dashboard.buildings.show', function ($breadcrumb, $building) {
    $breadcrumb->parent('dashboard.owners.show', $building->owner);
    $breadcrumb->push($building->name, route('dashboard.buildings.show', $building));
});
Breadcrumbs::for('dashboard.reports.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(__('reports.plural'), route('dashboard.reports.monthly'));
});

Breadcrumbs::for('dashboard.buildings.edit', function ($breadcrumb, $building) {
    $breadcrumb->parent('dashboard.buildings.show', $building);
    $breadcrumb->push(trans('buildings.actions.edit'), route('dashboard.buildings.edit', $building));
});
