<?php namespace App\Helpers;

/**
 * Currency
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Currency {

    /**
     * A currency amount.
     *
     * @var float|int
     */
    private $amount;

    /**
     * Constructor.
     *
     * @param int|float  $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Converts a number to a decimal dollar amount.
     *
     * @param  bool   $showSign
     * @return string
     */
    public function asDollar()
    {
        return '$' . number_format($this->amount, 2, '.', ',');
    }
}
