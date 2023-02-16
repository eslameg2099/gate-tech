<?php

return [
    'singular' => 'Service',
    'plural' => 'Services',
    'empty' => 'There are no services yet.',
    'count' => 'Services Count.',
    'search' => 'Search',
    'select' => 'Select Reason',
    'permission' => 'Manage services',
    'trashed' => 'Trashed services',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for service',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new service',
        'show' => 'Show service',
        'edit' => 'Edit service',
        'delete' => 'Delete service',
        'restore' => 'Restore',
        'forceDelete' => 'Delete Forever',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The service has been created successfully.',
        'updated' => 'The service has been updated successfully.',
        'deleted' => 'The service has been deleted successfully.',
        'restored' => 'The service has been restored successfully.',
    ],
    'attributes' => [
        'name' => 'Service name',
        '%name%' => 'Service name',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the service ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the service ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the service forever ?',
            'confirm' => 'Delete Forever',
            'cancel' => 'Cancel',
        ],
    ],
];
