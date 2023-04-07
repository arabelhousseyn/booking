<?php

use App\Enums\FirebaseTopic;
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
];
