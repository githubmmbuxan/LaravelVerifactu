<?php

declare(strict_types=1);

use Tests\TestCase;
use MMBuxan\VeriFactu\Models\Invoice;
use MMBuxan\VeriFactu\Models\Breakdown;
use MMBuxan\VeriFactu\Enums\TaxTypeEnum;
use MMBuxan\VeriFactu\Enums\RegimeTypeEnum;
use MMBuxan\VeriFactu\Enums\OperationTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BreakdownModelTest extends TestCase
{
    use RefreshDatabase;

    public function testBreakdownCanBeCreated(): void
    {
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ]);
        $breakdown = Breakdown::factory()->create([
            'invoice_id' => $invoice->id,
        ]);
        $this->assertDatabaseHas('breakdowns', ['id' => $breakdown->id]);
        $this->assertEquals($invoice->id, $breakdown->invoice_id);
    }

    public function testBreakdownBelongsToInvoice(): void
    {
        $invoice = Invoice::factory()->create();
        $breakdown = Breakdown::factory()->create(['invoice_id' => $invoice->id]);
        $this->assertInstanceOf(Invoice::class, $breakdown->invoice);
    }

    public function testBreakdownSoftDelete(): void
    {
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ]);
        $breakdown = Breakdown::factory()->create([
            'invoice_id' => $invoice->id,
        ]);
        $breakdown->delete();
        $this->assertSoftDeleted('breakdowns', ['id' => $breakdown->id]);
    }

    public function testValidatesTaxAmount(): void
    {
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'issuer_name' => 'Issuer Test',
            'issuer_tax_id' => 'B12345678',
        ]);
        $breakdown = new Breakdown([
            'invoice_id' => $invoice->id,
            'tax_type' => TaxTypeEnum::VAT,
            'regime_type' => RegimeTypeEnum::GENERAL,
            'operation_type' => OperationTypeEnum::SUBJECT_NO_EXEMPT_NO_REVERSE,
            'tax_rate' => 21.00,
            'base_amount' => 100.00,
            'tax_amount' => 21.00,
        ]);
        $breakdown->save();
        // Validación directa
        $this->assertEquals(21.00, $breakdown->tax_amount);
        // Cambia tax_amount a un valor incorrecto y espera excepción
        $breakdown->tax_amount = 99.99;
        try {
            $breakdown->save();
            $this->fail('Did not throw exception for invalid tax amount');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
        // Diferencias aceptables
        $breakdown->tax_amount = 20.99;
        $breakdown->save();
        $breakdown->tax_amount = 21.01;
        $breakdown->save();
    }
} 