<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use MMBuxan\VeriFactu\Models\Invoice;
use MMBuxan\VeriFactu\Models\Breakdown;
use MMBuxan\VeriFactu\Models\Recipient;
use Tests\TestCase;

class InvoiceModelTest extends TestCase
{
    use RefreshDatabase;

    public function testInvoiceCanBeCreated(): void
    {
        $invoice = Invoice::factory()->create([
            'number' => 'INV-100',
            'customer_name' => 'Test Customer',
            'issuer_name' => 'Test Issuer',
        ]);
        $this->assertDatabaseHas('invoices', ['number' => 'INV-100']);
        $this->assertEquals('Test Customer', $invoice->customer_name);
    }

    public function testInvoiceHasBreakdownsAndRecipients(): void
    {
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create();
        $breakdown = Breakdown::factory()->create(['invoice_id' => $invoice->id]);
        $recipient = Recipient::factory()->create(['invoice_id' => $invoice->id]);
        $this->assertTrue($invoice->breakdowns->contains($breakdown));
        $this->assertTrue($invoice->recipients->contains($recipient));
    }

    public function testInvoiceSoftDelete(): void
    {
        $invoice = Invoice::factory()->create();
        $invoice->delete();
        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);
    }

    public function testAdvancedInvoiceRegistration(): void
    {
        $invoiceData = [
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'number' => 'INV-ADV-001',
            'date' => now()->toDateString(),
            'customer_name' => 'Advanced Customer',
            'customer_tax_id' => 'C12345678',
            'customer_country' => 'ES',
            'issuer_name' => 'Advanced Issuer',
            'issuer_tax_id' => 'B87654321',
            'issuer_country' => 'ES',
            'amount' => 100.00,
            'tax' => 21.00,
            'total' => 121.00,
            'type' => \MMBuxan\VeriFactu\Enums\InvoiceType::STANDARD,
            'description' => 'Advanced invoice test',
            'status' => 'draft',
        ];
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create($invoiceData);
        // Relacionar breakdowns
        $breakdown = \Database\Factories\MMBuxan\VeriFactu\Models\BreakdownFactory::new()->create([
            'invoice_id' => $invoice->id,
            'tax_type' => \MMBuxan\VeriFactu\Enums\TaxTypeEnum::VAT,
            'regime_type' => \MMBuxan\VeriFactu\Enums\RegimeTypeEnum::GENERAL,
            'operation_type' => \MMBuxan\VeriFactu\Enums\OperationTypeEnum::SUBJECT_NO_EXEMPT_NO_REVERSE,
            'tax_rate' => 21.00,
            'base_amount' => 100.00,
            'tax_amount' => 21.00,
        ]);
        // Relacionar recipients
        $recipient = \Database\Factories\MMBuxan\VeriFactu\Models\RecipientFactory::new()->create([
            'invoice_id' => $invoice->id,
            'name' => 'Advanced Recipient',
            'tax_id' => 'C99999999',
            'country' => 'ES',
        ]);
        // Validaciones de base de datos
        $this->assertDatabaseHas('invoices', ['uuid' => $invoiceData['uuid'], 'number' => 'INV-ADV-001']);
        $this->assertDatabaseHas('breakdowns', ['invoice_id' => $invoice->id, 'tax_amount' => 21.00]);
        $this->assertDatabaseHas('recipients', ['invoice_id' => $invoice->id, 'name' => 'Advanced Recipient']);
        // Validaciones de relaciones
        $this->assertTrue($invoice->breakdowns->contains($breakdown));
        $this->assertTrue($invoice->recipients->contains($recipient));
        // Validación de cálculo total
        $expectedTotal = $invoice->amount + $invoice->tax;
        $this->assertEquals($expectedTotal, $invoice->total);
        // Validación de campos obligatorios
        $this->assertNotEmpty($invoice->uuid);
        $this->assertNotEmpty($invoice->issuer_name);
        $this->assertNotEmpty($invoice->issuer_tax_id);
        // Validación de breakdowns correctos
        $this->assertEquals(21.00, $breakdown->tax_amount);
        // Cambia tax_amount a un valor incorrecto y espera excepción
        $breakdown->tax_amount = 99.99;
        try {
            $breakdown->save();
            $this->fail('Did not throw exception for invalid tax amount in breakdown');
        } catch (\Exception $e) {
            $this->assertTrue(true);
        }
        // Diferencias aceptables
        // $breakdown->tax_amount = 20.99;
        // $breakdown->save();
        // $breakdown->tax_amount = 21.01;
        // $breakdown->save();
        
        // Validación del hash calculado y almacenado
        $hashData = [
            'issuer_tax_id' => $invoice->issuer_tax_id,
            'invoice_number' => $invoice->number,
            'issue_date' => $invoice->date instanceof \Illuminate\Support\Carbon ? $invoice->date->format('Y-m-d') : $invoice->date,
            'invoice_type' => $invoice->type instanceof \BackedEnum ? $invoice->type->value : (string)$invoice->type,
            'total_tax' => (string)$invoice->tax,
            'total_amount' => (string)$invoice->total,
            'previous_hash' => '',
            'generated_at' => $invoice->updated_at->format('c'),
        ];
        $expectedHash = \MMBuxan\VeriFactu\Helpers\HashHelper::generateInvoiceHash($hashData)['hash'];
        $this->assertEquals($expectedHash, $invoice->hash);
    }
} 