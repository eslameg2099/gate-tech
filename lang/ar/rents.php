<?php

return [
    'singular' => 'المستأجر',
    'plural' => 'المستأجرين',
    'empty' => 'لا يوجد مستأجرين حتى الان',
    'count' => 'عدد المستأجرين',
    'search' => 'بحث',
    'select' => 'اختر المستأجر',
    'permission' => 'ادارة المستأجرين',
    'trashed' => 'المستأجرين المحذوفة',
    'perPage' => 'عدد النتائج بالصفحة',
    'filter' => 'ابحث عن مستأجر',
    'payment' => 'دفع الايجار',
    'actions' => [
        'list' => 'عرض الكل',
        'create' => 'اضافة مستأجر',
        'show' => 'عرض المستأجر',
        'edit' => 'تعديل المستأجر',
        'delete' => 'حذف المستأجر',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'options' => 'خيارات',
        'save' => 'حفظ',
        'filter' => 'بحث',
        'payment' => 'دفع',
    ],
    'messages' => [
        'created' => 'تم اضافة المستأجر بنجاح.',
        'updated' => 'تم تعديل المستأجر بنجاح.',
        'deleted' => 'تم حذف المستأجر بنجاح.',
        'restored' => 'تم استعادة المستأجر بنجاح.',
        'paid' => 'تم دفع المبلغ بنجاح.',
    ],
    'errors' => [
        'overlap' => 'الوحدة غير متاحة في الفترة المحددة',
    ],
    'attributes' => [
        'user_id' => 'المستأجر',
        'apartment_id' => 'الوحدة',
        'from' => 'من',
        'to' => 'الى',
        'period' => 'الفترة',
        'renewable' => 'قابل للتجديد',
        'amount' => 'تكلفة الشهر',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد حذف المستأجر ؟',
            'confirm' => 'حذف',
            'cancel' => 'الغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد استعادة المستأجر ؟',
            'confirm' => 'استعادة',
            'cancel' => 'الغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل انت متأكد انك تريد حذف المستأجر نهائياً ؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'الغاء',
        ],
    ],
];
