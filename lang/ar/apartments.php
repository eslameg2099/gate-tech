<?php

return [
    'singular' => 'الوحدة',
    'number' => 'وحدة رقم :number',
    'plural' => 'الوحدات',
    'empty' => 'لا يوجد وحدات حتى الان',
    'count' => 'عدد الوحدات',
    'search' => 'بحث',
    'select' => 'اختر الوحدة',
    'rented' => 'الوحدات المستأجرة فقط',
    'all' => 'كل الوحدات',
    'permission' => 'ادارة الوحدات',
    'trashed' => 'الوحدات المحذوفة',
    'perPage' => 'عدد النتائج بالصفحة',
    'filter' => 'ابحث عن وحدة',
    'actions' => [
        'list' => 'عرض الكل',
        'create' => 'اضافة وحدة',
        'show' => 'عرض الوحدة',
        'edit' => 'تعديل الوحدة',
        'delete' => 'حذف الوحدة',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'options' => 'خيارات',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'messages' => [
        'created' => 'تم اضافة الوحدة بنجاح.',
        'updated' => 'تم تعديل الوحدة بنجاح.',
        'deleted' => 'تم حذف الوحدة بنجاح.',
        'restored' => 'تم استعادة الوحدة بنجاح.',
    ],
    'attributes' => [
        'number' => 'رقم الوحدة',
        'floor' => 'الطابق',
        'building_id' => 'البناية',
        'tenant' => 'المستأجر',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد حذف الوحدة ؟',
            'confirm' => 'حذف',
            'cancel' => 'الغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد استعادة الوحدة ؟',
            'confirm' => 'استعادة',
            'cancel' => 'الغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد حذف الوحدة نهائياً ؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'الغاء',
        ],
    ],
];