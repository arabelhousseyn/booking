<?php

use App\Enums\FirebaseTopic;
use App\Enums\ReasonTypes;
use App\Enums\UserDocumentType;

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
];
