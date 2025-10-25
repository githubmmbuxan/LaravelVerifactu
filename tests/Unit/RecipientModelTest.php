<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use MMBuxan\VeriFactu\Models\Invoice;
use MMBuxan\VeriFactu\Models\Recipient;
use Tests\TestCase;

class RecipientModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_recipient_can_be_created(): void
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

    public function test_recipient_belongs_to_invoice(): void
    {
        $invoice = Invoice::factory()->create();
        $recipient = Recipient::factory()->create(['invoice_id' => $invoice->id]);
        $this->assertInstanceOf(Invoice::class, $recipient->invoice);
    }

    public function test_recipient_soft_delete(): void
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
