<?php

use App\Enums\UserDocumentType;
use App\Enums\ReasonTypes;
use App\Enums\FirebaseTopic;

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
];
