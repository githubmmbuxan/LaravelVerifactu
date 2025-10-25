<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('tax_type', 5); // Enum TaxType
            $table->string('regime_type', 5); // Enum RegimeType
            $table->string('operation_type', 5); // Enum OperationType
            $table->decimal('tax_rate', 6, 2);
            $table->decimal('base_amount', 15, 2);
            $table->decimal('tax_amount', 15, 2);
            $table->decimal('equivalence_surcharge_rate', 6, 2)->nullable();
            $table->decimal('equivalence_surcharge_amount', 15, 2)->nullable();
            $table->string('exemption_code', 5)->nullable();
            $table->string('exemption_description', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('breakdowns');
    }
};
