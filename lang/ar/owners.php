<?php

return [
    'plural' => 'الملاك',
    'singular' => 'المالك',
    'empty' => 'لا توجد ملاك',
    'select' => 'اختر المالك',
    'permission' => 'ادارة الملاك',
    'trashed' => 'الملاك المحذوفين',
    'perPage' => 'عدد النتائج في الصفحة',
    'actions' => [
        'list' => 'كل الملاك',
        'show' => 'عرض',
        'create' => 'إضافة',
        'new' => 'إضافة',
        'edit' => 'تعديل  المالك',
        'delete' => 'حذف المالك',
        'restore' => 'استعادة',
        'forceDelete' => 'حذف نهائي',
        'save' => 'حفظ',
        'filter' => 'بحث',
    ],
    'messages' => [
        'created' => 'تم إضافة المالك بنجاح .',
        'updated' => 'تم تعديل المالك بنجاح .',
        'deleted' => 'تم حذف المالك بنجاح .',
        'restored' => 'تم استعادة المالك بنجاح .',
    ],
    'attributes' => [
        'name' => 'اسم المالك',
        'phone' => 'رقم الهاتف',
        'email' => 'البريد الالكترونى',
        'created_at' => 'تاريخ الإنضمام',
        'old_password' => 'كلمة المرور القديمة',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'type' => 'نوع المستخدم',
        'avatar' => 'الصورة الشخصية',
    ],
    'dialogs' => [
        'delete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا المالك ؟',
            'confirm' => 'حذف',
            'cancel' => 'إلغاء',
        ],
        'restore' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد استعادة هذا المالك ؟',
            'confirm' => 'استعادة',
            'cancel' => 'إلغاء',
        ],
        'forceDelete' => [
            'title' => 'تحذير !',
            'info' => 'هل أنت متأكد انك تريد حذف هذا المالك نهائياً؟',
            'confirm' => 'حذف نهائي',
            'cancel' => 'إلغاء',
        ],
    ],
];