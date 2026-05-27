<?php

namespace App\Models\Concerns;

trait HandlesNullableDecimals
{
    /**
     * Override fromDecimal to support nullable decimal values in MongoDB.
     *
     * @param  mixed  $value
     * @param  int  $decimals
     * @return \MongoDB\BSON\Decimal128|null
     */
    protected function fromDecimal($value, $decimals)
    {
        if (is_null($value) || $value === '') {
            return null;
        }

        return parent::fromDecimal($value, $decimals);
    }
}
