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
     * @return string
     */
    public function asDollar()
    {
        return '$' . number_format($this->amount, 2, '.', ',');
    }
}
