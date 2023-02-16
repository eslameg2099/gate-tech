<?php

return [
    'singular' => 'Installment',
    'plural' => 'Installments',
    'empty' => 'There are no installments yet.',
    'count' => 'Installments Count.',
    'search' => 'Search',
    'select' => 'Select Installment',
    'permission' => 'Manage installments',
    'trashed' => 'Trashed installments',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for installment',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new installment',
        'show' => 'Show installment',
        'edit' => 'Edit installment',
        'delete' => 'Delete installment',
        'restore' => 'Restore',
        'forceDelete' => 'Delete Forever',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The installment has been created successfully.',
        'updated' => 'The installment has been updated successfully.',
        'deleted' => 'The installment has been deleted successfully.',
        'restored' => 'The installment has been restored successfully.',
    ],
    'errors' => [
        'overlap' => 'The apartment is not available in the this period.',
    ],
    'attributes' => [
        'rent_id' => 'Tenant',
        'date' => 'Date',
        'amount' => 'Amount',
        'paid_amount' => 'Paid Amount',
        'status' => 'Status',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the installment ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the installment ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the installment forever ?',
            'confirm' => 'Delete Forever',
            'cancel' => 'Cancel',
        ],
    ],
];
