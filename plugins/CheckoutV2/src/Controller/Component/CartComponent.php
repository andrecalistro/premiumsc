<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

/**
 * Cart component
 *
 * @property \Checkout\Model\Table\CartsTable $Carts
 * @property \Checkout\Model\Table\ShipmentsTable $Shipments
 * @property Component\AuthComponent Auth
 * @property \Checkout\Controller\Component\OrderComponent $Order
 * @property \Checkout\Controller\Component\CorreiosComponent $Correios
 *
 * @property \Cake\Http\Session $session
 */
class CartComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $components = ['Auth', 'CheckoutV2.Order', 'CheckoutV2.Correios'];
    public $Carts;
    public $Shipments;
    private $session_id;
    public $controller = null;
    public $session = null;

    public function initialize(array $config)
    {
        $this->controller = $this->_registry->getController();
        $this->session = $this->controller->request->getSession();

        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        $this->session_id = $config['session_id'];
        $this->Carts->deleteAll(['modified <' => Time::now('America/Sao_Paulo')->subHour(2)->format("Y-m-d H:i:s")]);
//dd($this->Order);
//        if (!$this->Order) {
//            try {
//                $this->controller->loadComponent('CheckoutV2.Order');
//            } catch (\Exception $e) {
//            }
//        }
    }

    /**
     * @param null $session_id
     * @return array
     */
    public function getProducts($session_id = null)
    {
        !is_null($session_id) ?: $session_id = $this->session_id;

        $products = $this->Carts->find('Products', ['session_id' => $session_id]);

        $subtotal = $this->Carts->find('subTotal', ['session_id' => $session_id]);

        $this->session->check('zipcode') ? $zipcode = $this->session->read('zipcode') : $zipcode = '';
        $this->session->check('quote_price') ? $quote_price = $this->session->read('quote_price') : $quote_price = '0';
        $this->session->check('quote_price_format') ? $quote_price_format = $this->session->read('quote_price_format') : $quote_price_format = '--';
        $this->session->check('total_format') ? $total_format = $this->session->read('total_format') : $total_format = $subtotal->subtotal_format;
        $this->session->check('total') ? $total = $this->session->read('total') : $total = $subtotal->subtotal;

        return [
            'products' => $products,
            'subtotal' => $subtotal->subtotal,
            'subtotal_format' => 'R$ ' . number_format($subtotal->subtotal, 2, ",", "."),
            'zipcode' => $zipcode,
            'quote_price' => $quote_price,
            'quote_price_format' => $quote_price_format,
            'total_format' => $total_format,
            'total' => $total
        ];
    }

    /**
     * @param $products_id
     * @param $quantity
     * @param null $variations
     * @return array
     * @throws \Exception
     */
    public function add($products_id, $quantity, $variations = null)
    {
        //adding product to cart
        $product = $this->Carts->Products->get($products_id, [
            'contain' => [
                'ProductsVariations' => function ($q) use ($variations) {
                    return $q->where(['ProductsVariations.variations_id' => $variations[0]]);
                }
            ]
        ]);

        if ($product->stock_control) {
            if ($product->stock == 0) {
                throw new \Exception('Ops, não temos esse produto em nosso estoque', 404);
            }
        }

        if ($product->variations_tree && !$variations) {
            return ['status' => false, 'message' => 'Você deve selecionar uma opção para adicionar o produto ao carrinho'];
        }

        $conditions = [
            'session_id' => $this->session_id,
            'products_id' => $product->id
        ];
        if ($variations) {
            $conditions += ['variations_id IN' => $variations];
        }

        if ($cart = $this->Carts->find()->where($conditions)->first()) {
            if ($product->stock_control) {
                if ($product->variations_tree) {
                    if ($cart->quantity == $product->products_variations[0]->stock) {
                        throw new \Exception('Você não pode comprar mais que a quantidade disponível desse produto');
                    }
                } else {
                    if ($cart->quantity == $product->stock) {
                        throw new \Exception('Você não pode comprar mais que a quantidade disponível desse produto');
                    }
                }
            }
            $quantity = $quantity + $cart->quantity;
            $cart = $this->Carts->patchEntity($cart, ['quantity' => $quantity, 'unit_price' => $product->price_format['regular'], 'total_price' => $quantity * $product->price_format['regular']]);
        } else {
            $data = ['products_id' => $product->id, 'quantity' => $quantity];
            $data['unit_price'] = $product->price_format['regular'];
            $data['total_price'] = $data['quantity'] * $product->price_format['regular'];
            if ($variations) {
                $data['variations_id'] = $variations[0];
                $data['variations_sku'] = $product->products_variations[0]->sku;
            }
            $cart = $this->Carts->patchEntity($this->Carts->newEntity(), $data);
            $cart->customers_id = $this->Auth->user('id');
            $cart->session_id = $this->session_id;
        }
        $status = $this->Carts->save($cart);

        if ($status) {
            $this->clearValues();
        } else {
            $product = null;
        }

        return ['product' => isset($product->name) ? $product->name : null, 'cart' => $cart, 'status' => $status];
    }

    /**
     * @param $id
     * @return \App\Model\Entity\Cart|bool
     */
    public function increment($id)
    {
        $cart = $this->Carts->get($id);

        $quantity = $cart->quantity + 1;
        $total_price = $cart->unit_price * $quantity;

        $cart = $this->Carts->patchEntity($cart, ['quantity' => $quantity, 'total_price' => $total_price]);
        $result = $this->Carts->save($cart);

        $this->clearValues();
        return $result;
    }

    /**
     * @param $id
     * @return \App\Model\Entity\Cart|bool|mixed
     */
    public function decrement($id)
    {
        $cart = $this->Carts->get($id);

        if ($cart->quantity > 1) {
            $quantity = $cart->quantity - 1;
            $total_price = $cart->unit_price * $quantity;

            $cart = $this->Carts->patchEntity($cart, ['quantity' => $quantity, 'total_price' => $total_price]);
            $result = $this->Carts->save($cart);
        } else {
            $result = $this->Carts->delete($cart);
        }

        $this->clearValues();
        return $result;
    }

    /**
     * @param $id
     * @param $quantity
     * @return bool|\Cake\Http\Response|null
     * @throws \Exception
     */
    public function changeQuantity($id, $quantity)
    {
        if ($quantity >= 1) {

            $cart = $this->Carts->get($id);

            $total_price = $cart->unit_price * $quantity;

            $cart = $this->Carts->patchEntity($cart, ['quantity' => $quantity, 'total_price' => $total_price]);
            $this->clearValues(false);
            $this->Carts->save($cart);
            $this->setTotalCart();
            $this->recalculateValues();
            return true;
        }

        return $this->delete($id);
    }

    /**
     * @param null $id
     * @return bool|mixed
     * @throws \Exception
     */
    public function delete($id = null)
    {
        $cart = $this->Carts->get($id);
        $result = $this->Carts->delete($cart);

        $this->clearValues();
        return $result;
    }

    /**
     * @param $subtotal
     * @param int $quote_price
     */
    public function setTotalCart($subtotal = null, $quote_price = 0)
    {
        $discount = 0;
        if (!$subtotal) {
            $cart = $this->getProducts();
            $subtotal = $cart['subtotal'];
        }

        if ($this->session->check('quote_price')) {
            $quote_price = $this->session->read('quote_price');
        }

        if ($this->session->check('Coupon.discount')) {
            $discount = $this->session->read('Coupon.discount');
        }

        $total = $subtotal + $quote_price - $discount;
        $this->session->write('total', $total);
        $this->session->write('total_format', "R$ " . number_format($total, 2, ",", "."));
    }

    /**
     * @param bool $recalculate
     * @throws \Exception
     */
    public function clearValues($recalculate = true)
    {
        if ($this->session->check('orders_id')) {
            $this->Order->delete($this->session->read('orders_id'));
        }

        $this->session->delete('quote_title');
        $this->session->delete('quote_price');
        $this->session->delete('total');
        $this->session->delete('total_format');
        $this->session->delete('quote_price_format');
        $this->session->delete('orders_id');
        $this->session->delete('Coupon');

        if ($recalculate) {
            $this->recalculateValues();
        }
    }

    /**
     * @param $old_session_id
     * @param $new_session_id
     * @return bool
     */
    public function regenerateSessionId($old_session_id, $new_session_id)
    {
        $carts = $this->Carts->updateAll(['session_id' => $new_session_id], ['session_id' => $old_session_id]);
        return $carts > 0 ? true : false;
    }

    /**
     * @param array $conditions
     * @return int
     */
    public function deleteAll(array $conditions = [])
    {
        return $this->Carts->deleteAll($conditions);
    }

    /**
     * @throws \Exception
     */
    public function recalculateValues()
    {
        if ($this->session->check('zipcode') && $this->session->check('quote_code')) {
            $aux = explode('.', $this->session->read('quote_code'));

            $shipment_code = Inflector::camelize($aux[0]);
            $shipment_component = 'Checkout\Controller\Component\\' . $shipment_code . 'Component';
            $quote_id = $aux[1];

            $this->$shipment_code = new $shipment_component(new ComponentRegistry(), [
                'session_id' => $this->getController()->request->getSession()->id()
            ]);

            if (method_exists($this->$shipment_code, 'getQuote')) {
                $quotes = $this->$shipment_code->getQuote(['zipcode' => $this->session->read('zipcode')]);

                if (isset($quotes['quote'][$quote_id])) {
                    $quote = $quotes['quote'][$quote_id];

                    $this->session->write('quote_code', $quote['code']);
                    $this->session->write('quote_price', $quote['cost']);
                    $this->session->write('quote_title', $quote['title']);
                    $this->session->write('quote_price_format', $quote['text']);

                    $subtotal = $this->Carts->find('subTotal', ['session_id' => $this->session_id]);
                    $this->setTotalCart($subtotal->subtotal, $quote['cost']);
                }
            }
        }
    }

    public function getSubTotal()
    {
        return $this->Carts->find('subTotal', ['session_id' => Component::getController()->request->getSession()->id()]);
    }

    public function getQuotePrice()
    {
        return $this->session->read('quote_price');
    }

    public function getTotal()
    {
        $subtotal = $this->Carts->find('subTotal', ['session_id' => Component::getController()->request->getSession()->id()]);
        if (Component::getController()->request->getSession()->check('total_format')) {
            return Component::getController()->request->getSession()->read('total_format');
        }
        return $subtotal;
    }

    public function shippingIsRequired($products = null)
    {
        return Hash::extract($products, '{n}[shipping_control=1]');
    }
}
