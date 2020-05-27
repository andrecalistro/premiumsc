<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Http\Session;
use Cake\ORM\TableRegistry;

/**
 * Class CouponComponent
 * @package Checkout\Controller\Component
 *
 * @property Session session
 */
class CouponComponent extends Component
{
    protected $_defaultConfig = [];
    public $components = ['Auth', 'Order', 'Correios'];
    public $Carts;
    public $Shipments;
    private $session_id;
    public $controller = null;
    public $session = null;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $this->controller = $this->_registry->getController();
        $this->session = $this->controller->request->getSession();

        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->session_id = $this->session->id();
    }

    /**
     * @return array|bool
     */
    public function getDiscount()
    {
        if ($this->session->check('Coupon.discount')) {
            return [
                'regular' => $this->session->read('Coupon.discount'),
                'formatted' => 'R$' . number_format($this->session->read('Coupon.discount'), 2, ",", ".")
            ];
        }
        return false;
    }

    /**
     * @param $discount
     * @param $code
     * @param $coupons_id
     * @return bool
     */
    public function setCoupon($discount, $code, $coupons_id)
    {
        $this->session->write('Coupon.discount', $discount);
        $this->session->write('Coupon.code', $code);
        $this->session->write('Coupon.id', $coupons_id);
        return true;
    }
}