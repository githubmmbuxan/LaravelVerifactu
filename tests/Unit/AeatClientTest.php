<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use MMBuxan\VeriFactu\Services\AeatClient;
use MMBuxan\VeriFactu\Models\Invoice;
use MMBuxan\VeriFactu\Models\Breakdown;
use MMBuxan\VeriFactu\Models\Recipient;
use MMBuxan\VeriFactu\Enums\InvoiceType;
use MMBuxan\VeriFactu\Enums\TaxType;
use MMBuxan\VeriFactu\Enums\RegimeType;
use MMBuxan\VeriFactu\Enums\OperationType;

class AeatClientTest extends TestCase
{
    use RefreshDatabase;

    public function testAeatClientCanBeConfigured(): void
    {
        $client = new AeatClient('/path/to/cert.pem', 'password', false);
        $this->assertInstanceOf(AeatClient::class, $client);
    }

    public function testSendInvoiceReturnsSuccessOrError(): void
    {
        // Prepara datos reales
        $invoice = Invoice::create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'number' => 'TST-001',
            'date' => now(),
            'customer_name' => 'Test Customer',
            'customer_tax_id' => '12345678A',
            'issuer_name' => 'Issuer Test',
            'issuer_tax_id' => 'B12345678',
            'amount' => 100,
            'tax' => 21,
            'total' => 121,
            'type' => InvoiceType::STANDARD,
        ]);
        $invoice->breakdowns()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'tax_type' => TaxType::VAT,
            'regime_type' => RegimeType::GENERAL,
            'operation_type' => OperationType::SUBJECT_NO_EXEMPT_NO_REVERSE,
            'tax_rate' => 21,
            'base_amount' => 100,
            'tax_amount' => 21,
        ]);
        $invoice->recipients()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Test Customer',
            'tax_id' => '12345678A',
            'country' => 'ES',
        ]);

        $certPath = env('VERIFACTU_CERT_PATH', '/path/to/cert.pem');
        $certPassword = env('VERIFACTU_CERT_PASSWORD', 'password');
        $production = false;
        $client = new AeatClient($certPath, $certPassword, $production);

        // Si el certificado no existe, mockear SoapClient para evitar error real
        if (!file_exists($certPath)) {
            $this->markTestSkipped('Certificado no disponible para integración real.');
        }

        $result = $client->sendInvoice($invoice);
        $this->assertTrue(in_array($result['status'], ['success', 'error']));
        $this->assertArrayHasKey('request', $result);
        $this->assertArrayHasKey('response', $result);
    }
} 