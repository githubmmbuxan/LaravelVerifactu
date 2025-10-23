<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use MMBuxan\VeriFactu\Models\Recipient;
use MMBuxan\VeriFactu\Models\Invoice;
use Tests\TestCase;

class RecipientModelTest extends TestCase
{
    use RefreshDatabase;

    public function testRecipientCanBeCreated(): void
    {
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ]);
        $recipient = Recipient::factory()->create([
            'invoice_id' => $invoice->id,
        ]);
        $this->assertDatabaseHas('recipients', ['id' => $recipient->id]);
        $this->assertEquals($invoice->id, $recipient->invoice_id);
    }

    public function testRecipientBelongsToInvoice(): void
    {
        $invoice = Invoice::factory()->create();
        $recipient = Recipient::factory()->create(['invoice_id' => $invoice->id]);
        $this->assertInstanceOf(Invoice::class, $recipient->invoice);
    }

    public function testRecipientSoftDelete(): void
    {
        $invoice = \Database\Factories\MMBuxan\VeriFactu\Models\InvoiceFactory::new()->create([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
        ]);
        $recipient = Recipient::factory()->create([
            'invoice_id' => $invoice->id,
        ]);
        $recipient->delete();
        $this->assertSoftDeleted('recipients', ['id' => $recipient->id]);
    }
} 