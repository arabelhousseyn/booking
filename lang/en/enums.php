<?php

use App\Enums\UserDocumentType;
use App\Enums\ReasonTypes;
use App\Enums\FirebaseTopic;
use App\Enums\CouponType;
use App\Enums\CouponSystemType;
use App\Enums\CouponStatus;
use App\Enums\CouponValueType;
use App\Enums\ModelType;

return [
    UserDocumentType::class => [
        UserDocumentType::ID => 'ID',
        UserDocumentType::DOCUMENT_LICENSE_FRONT => 'Document driving license front',
        UserDocumentType::DOCUMENT_LICENSE_BACK => 'Document driving license back',
        UserDocumentType::FACE => 'Face',
        UserDocumentType::PASSPORT => 'Passport',
    ],

    ReasonTypes::class => [
        ReasonTypes::ALL => 'All',
        ReasonTypes::VEHICLES => 'Vehicles',
        ReasonTypes::HOUSES => 'Houses',
    ],

    FirebaseTopic::class => [
        FirebaseTopic::ALL => 'All',
        FirebaseTopic::SELLERS => 'Partners',
        FirebaseTopic::USERS => 'Users',
    ],

    CouponType::class => [
        CouponType::CUSTOM => 'Custom',
        CouponType::PERMANENT => 'Permanent',
    ],

    CouponSystemType::class => [
        CouponSystemType::ALL => 'All',
        CouponSystemType::HOUSE => 'House',
        CouponSystemType::VEHICLE => 'Vehicle',
    ],

    CouponStatus::class => [
        CouponStatus::ACTIVE => 'Active',
        CouponStatus::INACTIVE => 'Inactive',
    ],

    CouponValueType::class => [
        CouponValueType::STATIC => 'Static',
        CouponValueType::PERCENTAGE => 'Percentage',
    ],

    ModelType::class => [
        ModelType::HOUSE => 'House',
        ModelType::VEHICLE => 'Vehicle',
    ],
];
