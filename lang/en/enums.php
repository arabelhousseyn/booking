<?php

use App\Enums\UserDocumentType;
use App\Enums\ReasonTypes;
use App\Enums\FirebaseTopic;
use App\Enums\CouponType;
use App\Enums\CouponSystemType;
use App\Enums\CouponStatus;
use App\Enums\CouponValueType;
use App\Enums\ModelType;
use App\Enums\VehicleDocumentType;
use App\Enums\Status;
use App\Enums\Motorisation;
use App\Enums\GearBox;
use App\Enums\Permissions;
use App\Enums\BookingStatus;
use App\Enums\Notifications;
use App\Enums\PaymentStatus;

return [
    Permissions::class => [
        Permissions::CAN_MANAGE_DASHBOARD => 'Can manage dashboard',
        Permissions::CAN_MANAGE_ACCOUNTS => 'Can manage accounts',
        Permissions::CAN_MANAGE_ACCOUNTS__ADMINS => 'Can manage admins',
        Permissions::CAN_MANAGE_ACCOUNTS__USERS => 'Can manage users',
        Permissions::CAN_MANAGE_ACCOUNTS__PARTNERS => 'Can manage partners',
        Permissions::CAN_MANAGE_HOUSES => 'Can manage houses',
        Permissions::CAN_MANAGE_VEHICLES => 'Can manage vehicles',
        Permissions::CAN_MANAGE_BOOKINGS => 'Can manage bookings',
        Permissions::CAN_MANAGE_PROMO_CODES => 'Can manage promo codes',
        Permissions::CAN_MANAGE_REVIEWS => 'Can manage reviews',
        Permissions::CAN_MANAGE_ADS => 'Can manage ads',
        Permissions::CAN_MANAGE_SETTINGS => 'Can manage settings',
        Permissions::CAN_MANAGE_SETTINGS__GENERAL => 'Can manage general',
        Permissions::CAN_MANAGE_SETTINGS__RECLAMATIONS => 'Can manage reclamations',
        Permissions::CAN_MANAGE_SETTINGS__ROLES => 'Can manage roles and permissions',
        Permissions::CAN_MANAGE_SETTINGS__NOTIFICATIONS => 'Can manage notifications',
    ],

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

    VehicleDocumentType::class => [
        VehicleDocumentType::INSURANCE => 'Insurance',
        VehicleDocumentType::GREY_CARD => 'Grey card',
        VehicleDocumentType::TECHNICAL_CONTROL => 'Technical control',
    ],

    Status::class => [
        Status::PENDING => 'Pending',
        Status::PUBLISHED => 'Published',
        Status::DECLINED => 'Declined',
        Status::BOOKED => 'Booked',
    ],

    Motorisation::class => [
        Motorisation::GAS => 'Gas',
        Motorisation::GASOLINE => 'Gasoline',
        Motorisation::DIESEL => 'Diesel',
    ],

    GearBox::class => [
        GearBox::AUTOMATIC => 'Automatic',
        GearBox::MANUAL => 'Manual',
    ],

    BookingStatus::class => [
        BookingStatus::PENDING => 'Pending',
        BookingStatus::ACCEPTED => 'Accepted',
        BookingStatus::DECLINED => 'Declined',
        BookingStatus::COMPLETED => 'Completed',
    ],

    PaymentStatus::class => [
        PaymentStatus::PENDING => 'Pending',
        PaymentStatus::PAID => 'Paid',
    ],

    Notifications::class => [
        Notifications::BOOKING_DECLINED => 'Booking declined',
        Notifications::BOOKING_TERMINATED => 'Booking terminated',
        Notifications::NEW_HOUSE => 'New house',
        Notifications::NEW_VEHICLE => 'New vehicle',
        Notifications::SELLER_DISPUTE => 'Seller dispute',
        Notifications::USER_DISPUTE => 'User dispute',
        Notifications::SIGNUP_SELLER => 'Signup seller',
        Notifications::SIGNUP_USER => 'Signup user',
    ],
];
