<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Helpers;

class HashHelper
{
    private static array $invoiceRequiredFields = [
        'issuer_tax_id',
        'invoice_number',
        'issue_date',
        'invoice_type',
        'total_tax',
        'total_amount',
        'previous_hash',
        'generated_at',
    ];

    /**
     * Generates the hash for an invoice record.
     *
     * @param array $data Invoice record data in the correct order.
     * @return array ['hash' => string, 'inputString' => string]
     */
    public static function generateInvoiceHash(array $data): array
    {
        self::validateData(self::$invoiceRequiredFields, $data);
        $inputString = self::field('issuer_tax_id', $data['issuer_tax_id']);
        $inputString .= self::field('invoice_number', $data['invoice_number']);
        $inputString .= self::field('issue_date', $data['issue_date']);
        $inputString .= self::field('invoice_type', $data['invoice_type']);
        $inputString .= self::field('total_tax', $data['total_tax']);
        $inputString .= self::field('total_amount', $data['total_amount']);
        $inputString .= self::field('previous_hash', $data['previous_hash']);
        $inputString .= self::field('generated_at', $data['generated_at'], false);
        $hash = strtoupper(hash('sha256', $inputString, false));
        return ['hash' => $hash, 'inputString' => $inputString];
    }

    private static function validateData(array $requiredFields, array $data): void
    {
        $missing = array_diff($requiredFields, array_keys($data));
        if (!empty($missing)) {
            throw new \InvalidArgumentException('Missing required fields: ' . implode(', ', $missing));
        }
        $extra = array_diff(array_keys($data), $requiredFields);
        if (!empty($extra)) {
            throw new \InvalidArgumentException('Unexpected fields: ' . implode(', ', $extra));
        }
    }

    private static function field(string $name, string $value, bool $includeSeparator = true): string
    {
        $value = trim($value);
        return "{$name}={$value}" . ($includeSeparator ? '&' : '');
    }
} 