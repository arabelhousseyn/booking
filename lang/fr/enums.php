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
        Permissions::CAN_MANAGE_DASHBOARD => 'Peut gérer le tableau de bord',
        Permissions::CAN_MANAGE_ACCOUNTS => 'Peut gérer des comptes',
        Permissions::CAN_MANAGE_ACCOUNTS__ADMINS => 'Peut gérer les administrateurs',
        Permissions::CAN_MANAGE_ACCOUNTS__USERS => 'Peut gérer les utilisateurs',
        Permissions::CAN_MANAGE_ACCOUNTS__PARTNERS => 'Peut gérer des partenaires',
        Permissions::CAN_MANAGE_HOUSES => 'Peut gérer des maisons',
        Permissions::CAN_MANAGE_VEHICLES => 'Peut gérer des véhicules',
        Permissions::CAN_MANAGE_BOOKINGS => 'Peut gérer les réservations',
        Permissions::CAN_MANAGE_PROMO_CODES => 'Peut gérer les codes promotionnels',
        Permissions::CAN_MANAGE_REVIEWS => 'Peut gérer les avis',
        Permissions::CAN_MANAGE_ADS => 'Peut gérer les publicités',
        Permissions::CAN_MANAGE_SETTINGS => 'Peut gérer les paramètres',
        Permissions::CAN_MANAGE_SETTINGS__GENERAL => 'Peut gérer le général',
        Permissions::CAN_MANAGE_SETTINGS__RECLAMATIONS => 'Peut gérer les réclamations',
        Permissions::CAN_MANAGE_SETTINGS__ROLES => 'Peut gérer les rôles et les autorisations',
        Permissions::CAN_MANAGE_SETTINGS__NOTIFICATIONS => 'Peut gérer les notifications',
    ],

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
        Motorisation::GAS => 'Gaz',
        Motorisation::GASOLINE => 'Essance',
        Motorisation::DIESEL => 'Diesel',
    ],

    GearBox::class => [
        GearBox::AUTOMATIC => 'Automatique',
        GearBox::MANUAL => 'Manuel',
    ],

    BookingStatus::class => [
        BookingStatus::PENDING => 'En attente',
        BookingStatus::ACCEPTED => 'Accepté',
        BookingStatus::DECLINED => 'Refuser',
        BookingStatus::COMPLETED => 'Complété',
    ],

    PaymentStatus::class => [
        PaymentStatus::PENDING => 'En attente',
        PaymentStatus::PAID => 'Payé',
    ],

    Notifications::class => [
        Notifications::BOOKING_DECLINED => 'Réservation refusée',
        Notifications::BOOKING_TERMINATED => 'Réservation terminée',
        Notifications::NEW_HOUSE => 'Nouvelle maison',
        Notifications::NEW_VEHICLE => 'Nouvelle voiture',
        Notifications::SELLER_DISPUTE => 'Litige du vendeur',
        Notifications::USER_DISPUTE => 'Litige  d\'utilisateurs',
        Notifications::SIGNUP_SELLER => 'Vendeur inscrit',
        Notifications::SIGNUP_USER => 'Utilisateur inscrit',
    ],
];
