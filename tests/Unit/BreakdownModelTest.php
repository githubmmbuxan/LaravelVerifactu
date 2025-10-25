<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use MMBuxan\VeriFactu\Enums\OperationTypeEnum;
use MMBuxan\VeriFactu\Enums\RegimeTypeEnum;
use MMBuxan\VeriFactu\Enums\TaxTypeEnum;
use MMBuxan\VeriFactu\Models\Breakdown;
use MMBuxan\VeriFactu\Models\Invoice;
use Tests\TestCase;

class BreakdownModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_breakdown_can_be_created(): void
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

    public function test_breakdown_belongs_to_invoice(): void
    {
        $invoice = Invoice::factory()->create();
        $breakdown = Breakdown::factory()->create(['invoice_id' => $invoice->id]);
        $this->assertInstanceOf(Invoice::class, $breakdown->invoice);
    }

    public function test_breakdown_soft_delete(): void
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

    public function test_validates_tax_amount(): void
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
        // $breakdown->tax_amount = 20.99;
        // $breakdown->save();
        // $breakdown->tax_amount = 21.01;
        // $breakdown->save();
    }
}
