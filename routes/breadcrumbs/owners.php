<?php

Breadcrumbs::for('dashboard.owners.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('owners.plural'), route('dashboard.owners.index'));
});

Breadcrumbs::for('dashboard.owners.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.owners.index');
    $breadcrumb->push(trans('owners.trashed'), route('dashboard.owners.trashed'));
});

Breadcrumbs::for('dashboard.owners.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.owners.index');
    $breadcrumb->push(trans('owners.actions.create'), route('dashboard.owners.create'));
});

Breadcrumbs::for('dashboard.owners.show', function ($breadcrumb, $owner) {
    $breadcrumb->parent('dashboard.owners.index');
    $breadcrumb->push($owner->name, route('dashboard.owners.show', $owner));
});

Breadcrumbs::for('dashboard.owners.edit', function ($breadcrumb, $owner) {
    $breadcrumb->parent('dashboard.owners.show', $owner);
    $breadcrumb->push(trans('owners.actions.edit'), route('dashboard.owners.edit', $owner));
});
