<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MMBuxan\VeriFactu\Enums\TaxTypeEnum;
use MMBuxan\VeriFactu\Enums\RegimeTypeEnum;
use MMBuxan\VeriFactu\Enums\OperationTypeEnum;

class Breakdown extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function newFactory()
    {
        return \Database\Factories\MMBuxan\VeriFactu\Models\BreakdownFactory::new();
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
        'tax_type' => TaxTypeEnum::class,
        'regime_type' => RegimeTypeEnum::class,
        'operation_type' => OperationTypeEnum::class,
        'tax_rate' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
} 