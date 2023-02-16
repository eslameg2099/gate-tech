<?php

return [
    'singular' => 'Unit',
    'number' => 'Unit Number :number',
    'plural' => 'Units',
    'empty' => 'There are no units yet.',
    'count' => 'Units Count.',
    'search' => 'Search',
    'select' => 'Select Unit',
    'rented' => 'Only Rented Unit',
    'all' => 'All Units',
    'permission' => 'Manage units',
    'trashed' => 'Trashed units',
    'perPage' => 'Results Per Page',
    'filter' => 'Search for unit',
    'actions' => [
        'list' => 'List All',
        'create' => 'Create a new unit',
        'show' => 'Show unit',
        'edit' => 'Edit unit',
        'delete' => 'Delete unit',
        'restore' => 'Restore',
        'forceDelete' => 'Delete Forever',
        'options' => 'Options',
        'save' => 'Save',
        'filter' => 'Filter',
    ],
    'messages' => [
        'created' => 'The unit has been created successfully.',
        'updated' => 'The unit has been updated successfully.',
        'deleted' => 'The unit has been deleted successfully.',
        'restored' => 'The unit has been restored successfully.',
    ],
    'attributes' => [
        'number' => 'Unit number',
        'floor' => 'Floor',
        'building_id' => 'Building',
        'tenant' => 'Tenant',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the unit ?',
            'confirm' => 'Delete',
            'cancel' => 'Cancel',
        ],
        'restore' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to restore the unit ?',
            'confirm' => 'Restore',
            'cancel' => 'Cancel',
        ],
        'forceDelete' => [
            'title' => 'Warning !',
            'info' => 'Are you sure you want to delete the unit forever ?',
            'confirm' => 'Delete Forever',
            'cancel' => 'Cancel',
        ],
    ],
];
