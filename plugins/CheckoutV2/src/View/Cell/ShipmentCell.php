<?php

namespace CheckoutV2\View\Cell;

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
        $themeFile = ROOT . DS . 'plugins' . DS . 'Theme' . DS . 'src' . DS . 'Template' . DS . 'Cell' . DS . 'Shipment' . DS . 'simulate_quote.ctp';
        if (file_exists($themeFile)) {
            $this->viewBuilder()->setPlugin('Theme');
        }
        $this->set('quote', $shipment);
    }

    public function chooseQuote($shipment)
    {
        $this->set('quote', $shipment);
    }

    public function chooseQuoteCheckout($shipment)
    {
        $this->set('quote', $shipment);
    }
}
