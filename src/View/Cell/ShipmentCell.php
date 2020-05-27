<?php

namespace App\View\Cell;

use Cake\Core\Configure;
use Cake\View\Cell;

/**
 * Shipment cell
 */
class ShipmentCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param $shipment
     */
    public function simulateQuote($shipment)
    {
        $this->viewBuilder()->setTheme(Configure::read('Theme'));
        $this->set('quote', $shipment);
    }

    public function chooseQuote($shipment)
    {
        $this->viewBuilder()->setTheme(Configure::read('Theme'));
        $this->set('quote', $shipment);
    }

	public function chooseQuoteCheckout($shipment)
	{
		$this->viewBuilder()->setTheme(Configure::read('Theme'));
		$this->set('quote', $shipment);
	}
}
