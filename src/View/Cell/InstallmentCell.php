<?php

namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Installment cell
 */
class InstallmentCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param $store
     * @param $price
     */
    public function short($store, $price)
    {
        $installment = false;
        if ($store->installment_show && $store->installment_max > 0) {
            $installments = $this->installments($store, $price);
            $installment = array_pop($installments);
        }
        $this->set(compact('installment'));
    }

    public function product($store, $price)
    {
        $installments = [];
        if ($store->installment_show && $store->installment_max > 0) {
            $installments = $this->installments($store, $price);
        }
        $this->set(compact('installments'));
    }

    /**
     * @param $store
     * @param $price
     * @return array
     */
    protected function installments($store, $price)
    {
        $installments = [];
        $interest = str_replace(',', '.', $store->installment_tax_interest) / 100;
        $installment_max = $store->installment_max > 0 ? $store->installment_max : 1;
        for ($i = 1; $i <= $installment_max; $i++) {
            if ($i <= $store->installment_without_interest) {
                $price_without_installment = ($price / $i);
                if ($price_without_installment >= $store->installment_min) {
                    $installments[] = [
                        'installment' => $i,
                        'price' => 'R$ ' . number_format($price_without_installment, 2, ",", "."),
                        'text' => 'sem juros'
                    ];
                }
            } else {
                $price_with_installment = $price / ((1 - pow((1 - $interest), $i)) / $interest);
                if ($price_with_installment >= $store->installment_min) {
                    $installments[] = [
                        'installment' => $i,
                        'price' => 'R$ ' . number_format($price_with_installment, 2, ",", "."),
                        'text' => 'com juros'
                    ];
                }
            }
        }
        return $installments;
    }

}
