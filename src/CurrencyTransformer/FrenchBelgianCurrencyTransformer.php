<?php

namespace NumberToWords\CurrencyTransformer;

use NumberToWords\Legacy\Numbers\Words;

class FrenchBelgianCurrencyTransformer implements CurrencyTransformer
{
    /**
     * {@inheritdoc}
     */
    public function toWords($amount, $currency='EUR', $options = null)
    {
        $converter = new Words($options);

        return $converter->transformToCurrency($amount, 'fr_BE', $currency);
    }
}
