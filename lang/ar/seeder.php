<?php

use Illuminate\Support\Str;

return [
    /** إعدادات التطبيق */

    'authorize-login' => 'تفويض الدخول',
    'override-bssid' => 'تجاوز BSSID',
    '24-hour-format' => 'تنسيق 24 ساعة',
    'bs' => 'التاريخ بالتقويم البهائي',
    'attendance-note' => 'ملاحظة الحضور',

    /** الإعدادات العامة */

    'firebase_key'=> 'مفتاح Firebase',
    'firebase_key_description' => 'مفتاح Firebase ضروري لإرسال الإشعارات إلى الهاتف المحمول.',
    'attendance_notify' => 'تعيين عدد الأيام للإشعارات المحلية',
    'attendance_notify_description' => 'تعيين عدد الأيام سيؤدي إلى إرسال بيانات تلك الأيام تلقائيًا إلى التطبيق المحمول. سيسمح تلقي هذه البيانات على الطرف المحمول للتطبيق بتعيين إشعارات دفع محلية لتلك التواريخ. ستساعد الإشعارات المحلية الموظفين على تذكر التحقق من الدخول في الوقت المحدد وكذلك التحقق من الخروج عندما يقترب نهاية الوردية.',
    'advance_salary_limit' => 'حد الراتب المسبق (%)',
    'advance_salary_limit_description' => 'تحديد الحد الأقصى للمبلغ الذي يمكن للموظف طلبه مسبقًا بناءً على الراتب الإجمالي.',
    'employee_code_prefix' => 'بادئة رمز الموظف',
    'employee_code_prefix_description' => 'سيتم استخدام هذه البادئة لإنشاء رمز الموظف.',
    'attendance_limit' => 'حد الحضور',
    'attendance_limit_description' => 'حد الحضور للتحقق من الدخول والخروج.',
    'award_display_limit' => 'حد عرض الجوائز',
    'award_display_limit_description' => 'حد عرض الجوائز في التطبيق المحمول.',
];
