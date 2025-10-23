<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Helpers;

class StringHelper
{
    /**
     * Sanitizes a string by trimming whitespace and replacing '&' and '<' characters.
     *
     * @param string $inputString The string to sanitize.
     * @return string The sanitized string.
     */
    public static function sanitize(string $inputString): string
    {
        $trimmedString = trim($inputString);
        $sanitizedString = str_replace(['&', '<'], ['&amp;', '&lt;'], $trimmedString);
        return $sanitizedString;
    }
} 