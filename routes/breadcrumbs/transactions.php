<?php

Breadcrumbs::for('dashboard.transactions.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('transactions.plural'), route('dashboard.transactions.index'));
});

Breadcrumbs::for('dashboard.transactions.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.transactions.index');
    $breadcrumb->push(trans('transactions.trashed'), route('dashboard.transactions.trashed'));
});

Breadcrumbs::for('dashboard.transactions.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.transactions.index');
    $breadcrumb->push(trans('transactions.actions.create'), route('dashboard.transactions.create'));
});

Breadcrumbs::for('dashboard.transactions.show', function ($breadcrumb, $transaction) {
    $breadcrumb->parent('dashboard.transactions.index');
    $breadcrumb->push('#'.$transaction->id, route('dashboard.transactions.show', $transaction));
});

Breadcrumbs::for('dashboard.transactions.edit', function ($breadcrumb, $transaction) {
    $breadcrumb->parent('dashboard.transactions.show', $transaction);
    $breadcrumb->push(trans('transactions.actions.edit'), route('dashboard.transactions.edit', $transaction));
});
