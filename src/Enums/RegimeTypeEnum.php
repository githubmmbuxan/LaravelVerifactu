<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Enums;

enum RegimeTypeEnum: string
{
    case GENERAL = '01';
    case EXPORT = '02';
    case USED_GOODS = '03';
    case GOLD_INVESTMENT = '04';
    case TRAVEL_AGENCIES = '05';
    case ENTITY_GROUP = '06';
    case CASH_CRITERION = '07';
    case IPSI_IGIC = '08';
    case TRAVEL_AGENCY_MEDIATION = '09';
    case THIRD_PARTY_COLLECTIONS = '10';
    case BUSINESS_LEASE = '11';
    case IVA_CERTIFICATIONS = '14';
    case IVA_SUCCESSIVE = '15';
    case CHAPTER_XI = '17';
    case EQUIVALENCE_SURCHARGE = '18';
    case REAGYP = '19';
    case SIMPLIFIED = '20';

    public function description(): string
    {
        return match($this) {
            self::GENERAL => 'General regime operation.',
            self::EXPORT => 'Export operation.',
            self::USED_GOODS => 'Special regime for used goods, art, antiques, and collectibles.',
            self::GOLD_INVESTMENT => 'Special regime for gold investment.',
            self::TRAVEL_AGENCIES => 'Special regime for travel agencies.',
            self::ENTITY_GROUP => 'Special regime for VAT group of entities (Advanced Level).',
            self::CASH_CRITERION => 'Special regime for cash criterion.',
            self::IPSI_IGIC => 'Operations subject to IPSI/IGIC.',
            self::TRAVEL_AGENCY_MEDIATION => 'Travel agency mediation services.',
            self::THIRD_PARTY_COLLECTIONS => 'Third-party collections.',
            self::BUSINESS_LEASE => 'Business premises lease.',
            self::IVA_CERTIFICATIONS => 'VAT pending for certifications.',
            self::IVA_SUCCESSIVE => 'VAT pending for successive operations.',
            self::CHAPTER_XI => 'Regime under Chapter XI Title IX (OSS/IOSS).',
            self::EQUIVALENCE_SURCHARGE => 'Equivalence surcharge.',
            self::REAGYP => 'Special regime for agriculture, livestock, and fishing.',
            self::SIMPLIFIED => 'Simplified regime.',
        };
    }
} 