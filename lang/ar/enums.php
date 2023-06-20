<?php

use App\Enums\BookingStatus;
use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use App\Enums\FirebaseTopic;
use App\Enums\GearBox;
use App\Enums\ModelType;
use App\Enums\Motorisation;
use App\Enums\Notifications;
use App\Enums\PaymentStatus;
use App\Enums\Permissions;
use App\Enums\ReasonTypes;
use App\Enums\Status;
use App\Enums\UserDocumentType;
use App\Enums\VehicleDocumentType;

return [
    Permissions::class => [
        Permissions::CAN_MANAGE_DASHBOARD => 'يمكن إدارة لوحة القيادة',
        Permissions::CAN_MANAGE_ACCOUNTS => 'يمكنه إدارة الحسابات',
        Permissions::CAN_MANAGE_ACCOUNTS__ADMINS => 'يمكن إدارة المشرفين',
        Permissions::CAN_MANAGE_ACCOUNTS__USERS => 'يمكن إدارة المستخدمين',
        Permissions::CAN_MANAGE_ACCOUNTS__PARTNERS => 'يمكن إدارة الشركاء',
        Permissions::CAN_MANAGE_HOUSES => 'يمكن إدارة المنازل',
        Permissions::CAN_MANAGE_VEHICLES => 'يمكنه إدارة المركبات',
        Permissions::CAN_MANAGE_BOOKINGS => 'يمكن إدارة الحجوزات',
        Permissions::CAN_MANAGE_PROMO_CODES => 'يمكن إدارة الرموز الترويجية',
        Permissions::CAN_MANAGE_REVIEWS => 'يمكنه إدارة المراجعات',
        Permissions::CAN_MANAGE_SETTINGS => 'يمكن إدارة الإعدادات',
        Permissions::CAN_MANAGE_SETTINGS__GENERAL => 'يمكن أن يدير العام',
        Permissions::CAN_MANAGE_SETTINGS__RECLAMATIONS => 'يمكن إدارة عمليات الاستصلاح',
        Permissions::CAN_MANAGE_SETTINGS__ROLES => 'يمكن إدارة الأدوار والأذونات',
        Permissions::CAN_MANAGE_SETTINGS__NOTIFICATIONS => 'يمكن إدارة الإخطارات',
    ],

    UserDocumentType::class => [
        UserDocumentType::ID => 'بطاقة تعريف',
        UserDocumentType::DOCUMENT_LICENSE_FRONT => 'وثيقة رخصة القيادة الأمامية',
        UserDocumentType::DOCUMENT_LICENSE_BACK => 'استرجاع رخصة القيادة',
        UserDocumentType::FACE => 'وجه',
        UserDocumentType::PASSPORT => 'جواز سفر',
    ],

    ReasonTypes::class => [
        ReasonTypes::ALL => 'الجميع',
        ReasonTypes::VEHICLES => 'مركبات',
        ReasonTypes::HOUSES => 'منازل',
    ],

    FirebaseTopic::class => [
        FirebaseTopic::ALL => 'الجميع',
        FirebaseTopic::SELLERS => 'شركاء',
        FirebaseTopic::USERS => 'المستخدمون',
    ],

    CouponType::class => [
        CouponType::CUSTOM => 'مخصص',
        CouponType::PERMANENT => 'دائم',
    ],

    CouponSystemType::class => [
        CouponSystemType::ALL => 'الجميع',
        CouponSystemType::HOUSE => 'عربة',
        CouponSystemType::VEHICLE => 'منزل',
    ],

    CouponStatus::class => [
        CouponStatus::ACTIVE => 'نشيط',
        CouponStatus::INACTIVE => 'غير نشط',
    ],

    CouponValueType::class => [
        CouponValueType::STATIC => 'ثابتة',
        CouponValueType::PERCENTAGE => 'نسبة مئوية',
    ],

    ModelType::class => [
        ModelType::HOUSE => 'منزل',
        ModelType::VEHICLE => 'عربة',
    ],

    VehicleDocumentType::class => [
        VehicleDocumentType::INSURANCE => 'تأمين',
        VehicleDocumentType::GREY_CARD => 'بطاقة رمادية',
        VehicleDocumentType::TECHNICAL_CONTROL => 'التحكم الفني',
    ],

    Status::class => [
        Status::PENDING => 'قيد الانتظار',
        Status::PUBLISHED => 'نشرت',
        Status::DECLINED => 'رفض',
        Status::BOOKED => 'حجز',
    ],

    Motorisation::class => [
        Motorisation::GAS => 'غاز',
        Motorisation::GASOLINE => 'الغازولين',
        Motorisation::DIESEL => 'ديزل',
    ],

    GearBox::class => [
        GearBox::AUTOMATIC => 'تلقائي',
        GearBox::MANUAL => 'يدوي',
    ],

    BookingStatus::class => [
        BookingStatus::PENDING => 'قيد الانتظار',
        BookingStatus::ACCEPTED => 'قبلت',
        BookingStatus::DECLINED => 'انخفض',
        BookingStatus::COMPLETED => 'مكتمل',
    ],

    PaymentStatus::class => [
        PaymentStatus::PENDING => 'قيد الانتظار',
        PaymentStatus::PAID => 'مدفوع',
    ],

    Notifications::class => [
        Notifications::BOOKING_DECLINED => 'رفض الحجز',
        Notifications::BOOKING_TERMINATED => 'تم إنهاء الحجز',
    ],
];
