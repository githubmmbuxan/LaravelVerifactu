<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Enums;

enum ForeignIdType: string
{
    case VAT = '02';
    case PASSPORT = '03';
    case NATIONAL_ID = '04';
    case RESIDENCE_CERTIFICATE = '05';
    case OTHER_DOCUMENT = '06';
    case UNREGISTERED = '07';

    public function description(): string
    {
        return match ($this) {
            self::VAT => 'VAT ID',
            self::PASSPORT => 'Passport',
            self::NATIONAL_ID => 'National ID issued by country of residence',
            self::RESIDENCE_CERTIFICATE => 'Residence certificate',
            self::OTHER_DOCUMENT => 'Other supporting document',
            self::UNREGISTERED => 'Unregistered',
        };
    }
}
