<?php namespace App\Helpers;

/**
 * Currency
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class Currency {

    /**
     * The currency amount.
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
     * Formats amount as a dollar amount.
     *
     * @param  bool  $showSign
     * @return string
     */
    public function asDollar($showSign = TRUE)
    {
        $amount = ($showSign) ? '$' : '';
        $amount .= number_format($this->amount, 2, '.', ',');

        return $amount;
    }
}
