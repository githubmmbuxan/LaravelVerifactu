<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('number')->unique();
            $table->date('date');
            $table->string('customer_name', 120);
            $table->string('customer_tax_id', 20);
            $table->string('customer_country', 2)->nullable();
            $table->string('issuer_name', 120);
            $table->string('issuer_tax_id', 20);
            $table->string('issuer_country', 2)->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('type', 3); // Enum InvoiceType
            $table->string('external_reference', 60)->nullable();
            $table->string('description', 500)->nullable();
            $table->string('status', 30)->default('draft');
            $table->string('hash', 64)->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
