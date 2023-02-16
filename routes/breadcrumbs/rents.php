<?php

Breadcrumbs::for('dashboard.rents.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('rents.plural'), route('dashboard.rents.index'));
});

Breadcrumbs::for('dashboard.rents.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.rents.index');
    $breadcrumb->push(trans('rents.trashed'), route('dashboard.rents.trashed'));
});

Breadcrumbs::for('dashboard.rents.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.rents.index');
    $breadcrumb->push(trans('rents.actions.create'), route('dashboard.rents.create'));
});

Breadcrumbs::for('dashboard.rents.show', function ($breadcrumb, $rent) {
    $breadcrumb->parent('dashboard.apartments.show', $rent->apartment);
    $breadcrumb->push($rent->tenant->name, route('dashboard.apartments.rents.show', [$rent->apartment, $rent]));
});

Breadcrumbs::for('dashboard.rents.edit', function ($breadcrumb, $rent) {
    $breadcrumb->parent('dashboard.rents.show', $rent);
    $breadcrumb->push(trans('rents.actions.edit'), route('dashboard.rents.edit', $rent));
});
