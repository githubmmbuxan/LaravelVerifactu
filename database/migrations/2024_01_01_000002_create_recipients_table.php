<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->string('name', 120);
            $table->string('tax_id', 20);
            $table->string('country', 2)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('email', 120)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('type', 10)->nullable(); // For ForeignIdType if needed
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipients');
    }
};
