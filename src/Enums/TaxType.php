<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Enums;

enum TaxType: string
{
    case VAT = '01';
    case IPSI = '02';
    case IGIC = '03';
    case OTHER = '05';

    public function description(): string
    {
        return match($this) {
            self::VAT => 'Value Added Tax (VAT)',
            self::IPSI => 'Production, Services and Import Tax (IPSI) of Ceuta and Melilla',
            self::IGIC => 'Canary Islands General Indirect Tax (IGIC)',
            self::OTHER => 'Other taxes',
        };
    }
} 