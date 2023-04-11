<?php

use App\Enums\CouponStatus;
use App\Enums\CouponSystemType;
use App\Enums\CouponType;
use App\Enums\CouponValueType;
use App\Enums\FirebaseTopic;
use App\Enums\GearBox;
use App\Enums\ModelType;
use App\Enums\Motorisation;
use App\Enums\ReasonTypes;
use App\Enums\Status;
use App\Enums\UserDocumentType;
use App\Enums\VehicleDocumentType;

return [
    UserDocumentType::class => [
        UserDocumentType::ID => 'IDENTIFIANT',
        UserDocumentType::DOCUMENT_LICENSE_FRONT => 'Document permis de conduire recto',
        UserDocumentType::DOCUMENT_LICENSE_BACK => 'Document permis de conduire retour',
        UserDocumentType::FACE => 'Visage',
        UserDocumentType::PASSPORT => 'Passeport',
    ],

    ReasonTypes::class => [
        ReasonTypes::ALL => 'Tout',
        ReasonTypes::VEHICLES => 'Véhicules',
        ReasonTypes::HOUSES => 'Maisons',
    ],

    FirebaseTopic::class => [
        FirebaseTopic::ALL => 'Tout',
        FirebaseTopic::SELLERS => 'Partenaires',
        FirebaseTopic::USERS => 'Utilisateurs',
    ],

    CouponType::class => [
        CouponType::CUSTOM => 'Coutume',
        CouponType::PERMANENT => 'Permanent',
    ],

    CouponSystemType::class => [
        CouponSystemType::ALL => 'Tout',
        CouponSystemType::HOUSE => 'Véhicules',
        CouponSystemType::VEHICLE => 'Maisons',
    ],

    CouponStatus::class => [
        CouponStatus::ACTIVE => 'Actif',
        CouponStatus::INACTIVE => 'Inactif',
    ],

    CouponValueType::class => [
        CouponValueType::STATIC => 'Statique',
        CouponValueType::PERCENTAGE => 'Pourcentage',
    ],

    ModelType::class => [
        ModelType::HOUSE => 'Maison',
        ModelType::VEHICLE => 'Véhicule',
    ],

    VehicleDocumentType::class => [
        VehicleDocumentType::INSURANCE => 'Assurance',
        VehicleDocumentType::GREY_CARD => 'Carte grise',
        VehicleDocumentType::TECHNICAL_CONTROL => 'Contrôle technique',
    ],

    Status::class => [
        Status::PENDING => 'En attente',
        Status::PUBLISHED => 'Publié',
        Status::DECLINED => 'refuser',
        Status::BOOKED => 'Réservé',
    ],

    Motorisation::class => [
        Motorisation::MATZOT => 'Matzot',
        Motorisation::GASOLINE => 'Gas',
        Motorisation::DIESEL => 'Diesel',
    ],

    GearBox::class => [
        GearBox::AUTOMATIC => 'Automatique',
        GearBox::MANUAL => 'Manuel',
    ],
];
