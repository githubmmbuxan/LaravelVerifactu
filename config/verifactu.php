<?php

return [
    'enabled' => true,
    'default_currency' => 'EUR',
    'issuer' => [
        'name' => env('VERIFACTU_ISSUER_NAME', ''),
        'vat' => env('VERIFACTU_ISSUER_VAT', ''),
    ],
    'enable_breakdown_validation' => env('VERIFACTU_ENABLE_BREAKDOWN_VALIDATION', true),
    // Otros parámetros de configuración...
];
