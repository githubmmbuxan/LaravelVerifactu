<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Enums;

enum InvoiceType: string
{
    case STANDARD = 'F1';
    case SIMPLIFIED = 'F2';
    case SUBSTITUTE = 'F3';
    case RECTIFICATIVE_R1 = 'R1';
    case RECTIFICATIVE_R2 = 'R2';
    case RECTIFICATIVE_R3 = 'R3';
    case RECTIFICATIVE_R4 = 'R4';
    case RECTIFICATIVE_R5 = 'R5';

    public function description(): string
    {
        return match ($this) {
            self::STANDARD => 'Standard invoice (art. 6, 7.2 and 7.3 RD 1619/2012)',
            self::SIMPLIFIED => 'Simplified invoice and invoices without recipient identification art. 6.1.d) RD 1619/2012',
            self::SUBSTITUTE => 'Invoice issued as a substitute for previously declared simplified invoices',
            self::RECTIFICATIVE_R1 => 'Rectifying invoice (legal error and Art. 80.1, 80.2, 80.6 LIVA)',
            self::RECTIFICATIVE_R2 => 'Rectifying invoice (Art. 80.3)',
            self::RECTIFICATIVE_R3 => 'Rectifying invoice (Art. 80.4)',
            self::RECTIFICATIVE_R4 => 'Rectifying invoice (Other)',
            self::RECTIFICATIVE_R5 => 'Rectifying invoice for simplified invoices',
        };
    }
}
