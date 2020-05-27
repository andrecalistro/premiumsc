<?php

namespace Admin\View\Cell;

use Cake\Core\Configure;
use Cake\View\Cell;

/**
 * VariationGroup cell
 */
class VariationGroupCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param $variations_group
     * @param null $variations
     */
    public function display($variations_group, $variations = null)
    {
        $uniqid = uniqid();
        $this->set(compact('variations_group', 'uniqid', 'variations'));
    }

    /**
     * @param $variations_group
     */
    public function newVariation($variations_group)
    {
        $uniqid = uniqid();
        $this->set(compact('variations_group', 'uniqid'));
    }
}
