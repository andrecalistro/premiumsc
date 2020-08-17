<?php

namespace CheckoutV2\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\NotFoundException;
use CheckoutV2\Controller\Component\CartComponent;
use CheckoutV2\Controller\Component\CouponComponent;
use CheckoutV2\Model\Table\CouponsTable;

/**
 * Class CouponsController
 * @package Checkout\Controller
 *
 * @property CouponsTable Coupons
 * @property CartComponent Cart
 * @property CouponComponent Coupon
 */
class CouponsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('CheckoutV2.Coupon');
        $this->Auth->allow(['validateCart', 'getDiscount']);
    }

    /**
     * @throws \Exception
     */
    public function validateCart()
    {
        try {
            $status = true;

            if (!$this->request->is(['post'])) {
                throw new \Cake\Http\Exception\MethodNotAllowedException('O metodo suportado é somente POST, foi enviado um ' . $this->request->getMethod());
            }

            if (!$this->request->getData('code')) {
                throw new \Cake\Http\Exception\NotFoundException('É necessario informar o código do cupom');
            }

            $coupon = $this->Coupons->find('code', ['code' => $this->request->getData('code')])->first();
            if (!$coupon) {
                throw new RecordNotFoundException('Cupom não encontrado, por favor insira outro cupom');
            }

            $this->loadComponent('Checkout.Cart', [
                'session_id' => $this->request->getSession()->id()
            ]);

            $result = $this->Coupons->calcDiscount(
                $coupon,
                $this->Cart->getSubTotal(),
                $this->Cart->getTotal(),
                $this->Cart->getQuotePrice(),
                $this->Cart->getProducts()
            );

            $this->Cart->setTotalCart($result['subtotal']);

            if ($result) {
                $this->Coupon->setCoupon($result['discount'], $result['code'], $result['id']);
            }

            $this->set(compact('status'));
            $this->set('_serialize', ['status']);
        } catch (\Throwable $e) {
            return new Response([
                'statusCode' => $e->getCode(),
                'body' => $e->getMessage()
            ]);
        }
    }

    /**
     *
     */
    public function getDiscount()
    {
        $discount = $this->Coupon->getDiscount();
        $this->set(compact('discount'));
        $this->set('_serialize', ['discount']);
    }
}