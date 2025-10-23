<?php

declare(strict_types=1);

namespace MMBuxan\VeriFactu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function newFactory()
    {
        return \Database\Factories\MMBuxan\VeriFactu\Models\RecipientFactory::new();
    }

    protected $table = 'recipients';

    protected $fillable = [
        'invoice_id',
        'name',
        'tax_id',
        'country',
        // Otros campos relevantes
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
} 