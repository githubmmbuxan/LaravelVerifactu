<?php

use MMBuxan\VeriFactu\Enums\InvoiceType;
use MMBuxan\VeriFactu\Enums\OperationTypeEnum;
use MMBuxan\VeriFactu\Enums\RegimeTypeEnum;
use MMBuxan\VeriFactu\Enums\TaxTypeEnum;
use MMBuxan\VeriFactu\Models\Breakdown;
use MMBuxan\VeriFactu\Models\Invoice;

// Usa el TestCase de tu paquete
uses(Tests\TestCase::class);

it('can create and store a valid invoice with breakdown and hash', function () {
    // 1. Crear factura con todos los campos requeridos (como en el test unitario)
    $invoice = Invoice::factory()->create([
        'uuid' => (string) \Illuminate\Support\Str::uuid(),
        'number' => 'FAC-FEATURE-001',
        'date' => now()->toDateString(),
        'customer_name' => 'Feature Customer',
        'customer_tax_id' => 'C11111111',
        'customer_country' => 'ES',
        'issuer_name' => 'Feature Issuer',
        'issuer_tax_id' => 'B22222222',
        'issuer_country' => 'ES',
        'amount' => 100.00,
        'tax' => 21.00,
        'total' => 121.00,
        'type' => InvoiceType::STANDARD,
        'description' => 'Feature test invoice',
        'status' => 'draft',
    ]);

    // 2. Crear breakdown con enums (no strings)
    $breakdown = Breakdown::factory()->create([
        'invoice_id' => $invoice->id,
        'tax_type' => TaxTypeEnum::VAT,
        'regime_type' => RegimeTypeEnum::GENERAL,
        'operation_type' => OperationTypeEnum::SUBJECT_NO_EXEMPT_NO_REVERSE,
        'tax_rate' => 21.00,
        'base_amount' => 100.00,
        'tax_amount' => 21.00,
    ]);

    // 3. Verificaciones de base de datos
    expect($invoice->number)->toBe('FAC-FEATURE-001');
    expect($invoice->total)->toBe('121.00');
    expect($breakdown->tax_amount)->toBe('21.00');

    $this->assertDatabaseHas('invoices', [
        'uuid' => $invoice->uuid,
        'number' => 'FAC-FEATURE-001',
        'total' => 121.00,
    ]);

    $this->assertDatabaseHas('breakdowns', [
        'invoice_id' => $invoice->id,
        'tax_amount' => 21.00,
    ]);

    // 4. Verificar que el hash se generó correctamente
    expect($invoice->hash)->not()->toBeEmpty();
    expect($invoice->hash)->toBeString();
});

it('rejects invalid tax amount in breakdown', function () {
    $invoice = Invoice::factory()->create();
    $breakdown = new Breakdown([
        'invoice_id' => $invoice->id,
        'tax_type' => TaxTypeEnum::VAT,
        'regime_type' => RegimeTypeEnum::GENERAL,
        'operation_type' => OperationTypeEnum::SUBJECT_NO_EXEMPT_NO_REVERSE,
        'tax_rate' => 21.00,
        'base_amount' => 100.00,
        'tax_amount' => 99.99, // ❌ Inválido
    ]);

    expect(fn () => $breakdown->save())->toThrow(\InvalidArgumentException::class);
});
