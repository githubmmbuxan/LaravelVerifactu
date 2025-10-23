<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Enums;

enum OperationType: string
{
    case SUBJECT_NO_EXEMPT_NO_REVERSE = 'S1';
    case SUBJECT_NO_EXEMPT_REVERSE = 'S2';
    case NOT_SUBJECT_ARTICLES = 'N1';
    case NOT_SUBJECT_LOCALIZATION = 'N2';

    public function description(): string
    {
        return match($this) {
            self::SUBJECT_NO_EXEMPT_NO_REVERSE => 'Subject and not exempt - No reverse charge',
            self::SUBJECT_NO_EXEMPT_REVERSE => 'Subject and not exempt - With reverse charge',
            self::NOT_SUBJECT_ARTICLES => 'Not subject - Articles 7, 14, others',
            self::NOT_SUBJECT_LOCALIZATION => 'Not subject due to localization rules',
        };
    }
} 