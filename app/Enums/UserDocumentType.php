<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static PASSPORT()
 * @method static static ID()
 * @method static static DOCUMENT_LICENSE_FRONT()
 * @method static static DOCUMENT_LICENSE_BACK()
 * @method static static FACE()
 */
final class UserDocumentType extends Enum implements LocalizedEnum
{
    const PASSPORT = 'passport';
    const ID = 'id';
    const DOCUMENT_LICENSE_FRONT = 'document_license_front';
    const DOCUMENT_LICENSE_BACK = 'document_license_back';
    const FACE = 'face';

    public static function getLocalizationKey(): string
    {
        return 'enums.'.self::class;
    }
}
