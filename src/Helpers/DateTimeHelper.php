<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Helpers;

use DateTime;
use Exception;

class DateTimeHelper
{
    /**
     * Formats a DateTime object or a date/time string into ISO 8601 format.
     *
     * @param  DateTime|string  $dateTime  The DateTime object or date/time string to format.
     * @return string The formatted date/time string in ISO 8601 format (YYYY-MM-DDTHH:MM:SS+HH:MM).
     *
     * @throws Exception If the input is invalid or if the DateTime object cannot be created.
     */
    public static function formatIso8601(DateTime|string $dateTime): string
    {
        if (is_string($dateTime)) {
            try {
                $dateTime = new DateTime($dateTime);
            } catch (Exception $e) {
                throw new Exception('Invalid date/time string: '.$e->getMessage());
            }
        } elseif (! $dateTime instanceof DateTime) {
            throw new Exception('Input must be a DateTime object or a date/time string.');
        }

        return $dateTime->format('c');
    }

    /**
     * Formats a DateTime object or a date/time string as d-m-Y (e.g. 25-01-2025).
     *
     * @param  DateTime|string  $date  The DateTime object or date/time string to format.
     * @return string The formatted date/time string.
     *
     * @throws Exception If the input is invalid or if the DateTime object cannot be created.
     */
    public static function formatDate(DateTime|string $date): string
    {
        if (is_string($date)) {
            try {
                $dateTime = new DateTime($date);
            } catch (Exception $e) {
                throw new Exception('Invalid date/time string: '.$e->getMessage());
            }
        } elseif ($date instanceof DateTime) {
            $dateTime = $date;
        } else {
            throw new Exception('Input must be a DateTime object or a date/time string.');
        }

        return $dateTime->format('d-m-Y');
    }

    /**
     * Returns the current date and time in ISO 8601 format.
     *
     * @return string The current date and time in ISO 8601 format.
     */
    public static function nowIso8601(): string
    {
        $dateTime = new DateTime;

        return $dateTime->format(DateTime::ATOM);
    }
}
