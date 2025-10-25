<?php

namespace MMBuxan\VeriFactu\Observers;

use InvalidArgumentException;
use MMBuxan\VeriFactu\Models\Breakdown;

class BreakdownObserver
{
    public function saving(Breakdown $breakdown): void
    {
        // Solo validar si base_amount y tax_rate están definidos
        if ($breakdown->base_amount === null || $breakdown->tax_rate === null) {
            return;
        }

        $expectedTax = round($breakdown->base_amount * ($breakdown->tax_rate / 100), 2);
        $diff = abs($breakdown->tax_amount - $expectedTax);

        // Tolerancia de ±0.01 (como en tu test unitario)
        if ($diff > 0.01) {
            throw new InvalidArgumentException(
                "Invalid tax_amount: expected {$expectedTax}, got {$breakdown->tax_amount}"
            );
        }
    }
}
