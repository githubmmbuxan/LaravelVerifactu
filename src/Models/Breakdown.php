<?php

declare(strict_types=1);

namespace Squareetlabs\VeriFactu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Squareetlabs\VeriFactu\Enums\TaxType;
use Squareetlabs\VeriFactu\Enums\RegimeType;
use Squareetlabs\VeriFactu\Enums\OperationType;

class Breakdown extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function newFactory()
    {
        return \Database\Factories\Squareetlabs\VeriFactu\Models\BreakdownFactory::new();
    }

    protected $table = 'breakdowns';

    protected $fillable = [
        'invoice_id',
        'tax_type',
        'regime_type',
        'operation_type',
        'tax_rate',
        'base_amount',
        'tax_amount',
    ];

    protected $casts = [
        'tax_type' => TaxType::class,
        'regime_type' => RegimeType::class,
        'operation_type' => OperationType::class,
        'tax_rate' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
} 