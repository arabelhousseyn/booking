<?php

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use App\Enums\FirebaseTopic;
use App\Enums\ModelType;
use App\Enums\ReasonTypes;
use App\Enums\UserDocumentType;

return [
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
];
