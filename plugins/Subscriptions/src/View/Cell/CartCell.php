<?php

namespace Subscriptions\View\Cell;

use Cake\View\Cell;

/**
 * Cart cell
 */
class CartCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    public function steps($steps)
    {
        if ($steps) {
            for ($i = 1; $i < 5; $i++) {
                in_array($i, $steps) ? $result[$i] = 'ativo' : $result[$i] = '';
            }
        }
        $this->set('steps', $result);
    }
}