<?php

namespace CheckoutV2\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\View\CellTrait;
use CheckoutV2\Controller\Component\CartComponent;

/**
 * Carts Controller
 *
 * @property \CheckoutV2\Model\Table\CartsTable $Carts
 * @property \CheckoutV2\Model\Table\ShipmentsTable $Shipments
 * @property CartComponent $Cart
 */
class CartsController extends AppController
{
    use CellTrait;

    public $Shipments;

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
        $this->Carts->deleteAll(['modified <' => Time::now('America/Sao_Paulo')->subHour(2)->format("Y-m-d H:i:s")]);
    }

    /**
     * @param Event $event
     * @return \Cake\Network\Response|void|null
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
        $this->viewBuilder()->setLayout('CheckoutV2.checkout');
        $this->viewBuilder()->setLayout('CheckoutV2.checkout');
        $this->set('_steps', $this->_steps);
    }

    /**
     *
     */
    public function index()
    {
        $products = $this->Carts->find('Products', ['session_id' => $this->request->getSession()->id()]);
        $subtotal = $this->Carts->find('subTotal', ['session_id' => $this->request->getSession()->id()]);

        if (!$products) {
            $this->viewBuilder()->setTemplate('empty');
            $this->Cart->clearValues();
            $zipcode = '';
            $quote_price = '';
            $total = '';
        } else {
            $this->request->getSession()->check('zipcode') ? $zipcode = $this->request->getSession()->read('zipcode') : $zipcode = '';
            $this->request->getSession()->check('quote_price_format') ? $quote_price = $this->request->getSession()->read('quote_price_format') : $quote_price = '--';
            $this->request->getSession()->check('total_format') ? $total = $this->request->getSession()->read('total_format') : $total = $subtotal->subtotal_format;
            $this->request->getSession()->check('quote_title') ? $this->set('quote_title', $this->request->getSession()->read('quote_title')) : $this->set('quote_title', null);
            $this->request->getSession()->check('Coupon.discount') ? $this->set('coupon', '- R$ ' . number_format($this->request->getSession()->read('Coupon.discount'), 2, ",", ".")) : $this->set('coupon', '--');
            $this->request->getSession()->check('Coupon.code') ? $this->set('coupon_code', $this->request->getSession()->read('Coupon.code')) : $this->set('coupon_code', null);
        }

        $available_stock_options = array_merge(range(1, 9), range(10, 50, 10));

        $shipping_required = $this->Cart->shippingIsRequired($products);
        $textProducts = \count($products) > 1 ? \count($products) . ' itens' : '1 item';

        $this->pageTitle = 'Meu Carrinho';
        $this->set(compact('products', 'subtotal', 'zipcode', 'quote_price', 'total', 'available_stock_options', 'shipping_required', 'textProducts'));
        $this->set('_serialize', ['products']);
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $cart = $this->Carts->get($id, [
            'contain' => ['Customers', 'Products', 'ProductsVariations']
        ]);

        $this->set('cart', $cart);
        $this->set('_serialize', ['cart']);
    }

    /**
     *
     */
    public function add()
    {
        try {
            if ($this->request->is('post')) {
                //adding product to cart
                $product = $this->Cart->add($this->request->getData('products_id'), $this->request->getData('quantity'), $this->request->getData('variations'));

                if ($product) {
                    $message = __('Produto adicionado ao carrinho.');
                    //$this->Flash->success($message);
                    $status = true;
                } else {
                    $status = false;
                    $message = __('O produto não foi adicionado ao carrinho. Por favor, tente novamente.');
                    $this->Flash->error($message);
                }
            }
//            $this->set('product', isset($product->name) ? $product->name : null);
//            $this->set(compact('message', 'status'));
//            $this->set('_serialize', ['product', 'message', 'status']);
            return new Response([
                'statusCodes' => 200,
                'body' => \GuzzleHttp\json_encode([
                    'product' => isset($product->name) ? $product->name : '',
                    'message' => $message,
                    'status' => $status
                ])
            ]);
        } catch (\Throwable $e) {
            return new Response([
                'statusCodes' => $e->getCode(),
                'body' => \GuzzleHttp\json_encode([
                    'message' => $e->getMessage()
                ])
            ]);
        }
    }

    /**
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function increment($id)
    {
        $this->Cart->increment($id);
        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function decrement($id)
    {
        $this->Cart->decrement($id);
        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $id
     * @param $quantity
     * @return \Cake\Http\Response|null
     */
    public function changeQuantity($id, $quantity)
    {
        $result = $this->Cart->changeQuantity($id, $quantity);

        if (!$result['status']) {
            $this->Flash->error($result['message']);
        } else {
            $this->Flash->success($result['message']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param null $id
     * @return \Cake\Http\Response|null
     */
    public function delete($id = null)
    {
        if ($this->Cart->delete($id)) {
            $this->Flash->success(__('Produto removido do carrinho.'));
        } else {
            $this->Flash->error(__('O produto não foi removido. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function quote()
    {
        $this->Shipments = TableRegistry::getTableLocator()->get("CheckoutV2.Shipments");

        $address['zipcode'] = $this->request->getData('zipcode');

        if ($this->Auth->user()) {
            $address['document'] = $this->Auth->user('document_clean');
            if ($this->Auth->user('company_document_clean')) {
                $address['document'] = $this->Auth->user('company_document_clean');
            }
        }

        $shipments = $this->Shipments->find('enables')->toArray();
        $quotes = [];

        if ($shipments) {
            foreach ($shipments as $shipment) {
                $shipment_code = Inflector::camelize($shipment->code);

                $this->loadComponent('CheckoutV2.' . $shipment_code, [
                    'session_id' => $this->request->getSession()->id()
                ]);

                if (method_exists($this->$shipment_code, 'getQuote')) {
                    $quotes[] = $this->$shipment_code->getQuote($address);
                }
            }
        }

        $content = '';
        $allShipments = [];

        foreach ($quotes as $quote) {
            if (!$quote['error']) {
                foreach ($quote['quote'] as $shipment) {
                    $allShipments[] = $shipment;
                }
            }
        }

        usort($allShipments, function ($a, $b) {
            return floatval($a['cost']) - floatval($b['cost']);
        });

        foreach ($allShipments as $shipment) {
            $content .= $this->cell("CheckoutV2.Shipment::chooseQuote", [$shipment]);
        }

        if (empty($content)) {
            $content = '<p>Nenhuma opção de envio disponível para seu endereço.</p>';
        }

        return new Response(['body' => \GuzzleHttp\json_encode([
            'content' => $content
        ])]);
    }

    /**
     * @return Response
     */
    public function quoteChosen()
    {
        $data = $this->request->getData();
        if (isset($data['code']) && isset($data['price'])) {
            $this->request->getSession()->write('zipcode', $data['zipcode']);
            $this->request->getSession()->write('quote_code', $data['code']);
            $this->request->getSession()->write('quote_price', $data['price']);
            $this->request->getSession()->write('quote_title', $data['title']);
            $this->request->getSession()->write('quote_price_format', "R$ " . number_format($data['price'], 2, ",", "."));

            $cart = $this->Cart->getProducts();
            $this->Cart->setTotalCart($cart['subtotal'], $data['price']);

            return new Response(['body' => \GuzzleHttp\json_encode([
                'shipping_price' => "R$ " . number_format($data['price'], 2, ",", "."),
                'total' => $this->request->getSession()->read('total_format')
            ])]);
        }
    }

    /**
     * @param $products_id
     */
    function verifyVariation($products_id)
    {
        $product = $this->Carts->Products->get($products_id, ['contain' => ['ProductsVariations']]);
        $variation_required = !$product->variations_tree ? false : true;
        $this->set(compact('variation_required'));
        $this->set('_serialize', ['variation_required']);
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function productQuote()
    {
        $this->Shipments = TableRegistry::getTableLocator()->get("CheckoutV2.Shipments");

        $address['zipcode'] = $this->request->getData('zipcode');
        $product = $this->Carts->Products->get($this->request->getData('products_id'));
        $product->quantity = $this->request->getData('quantity');
        $price = empty($product->price_special) ? $product->price : $product->price_special;
        $product->total_price = $product->quantity * $price;

        $shipments = $this->Shipments->find('enables')->toArray();
        $quotes = [];

        if ($shipments) {
            foreach ($shipments as $shipment) {
                $shipment_code = Inflector::camelize($shipment->code);

                $this->loadComponent('CheckoutV2.' . $shipment_code, [
                    'session_id' => $this->request->getSession()->id()
                ]);

                if (method_exists($this->$shipment_code, 'getQuote')) {
                    $quotes[] = $this->$shipment_code->getQuote($address, $product);
                }
            }
        }

        $content = '';
        $allShipments = [];

        foreach ($quotes as $quote) {
            if (!$quote['error']) {
                foreach ($quote['quote'] as $shipment) {
                    $allShipments[] = $shipment;
                }
            }
        }

        usort($allShipments, function ($a, $b) {
            return floatval($a['cost']) - floatval($b['cost']);
        });

        foreach ($allShipments as $shipment) {
            $content .= $this->cell("CheckoutV2.Shipment::simulateQuote", [$shipment]);
        }

        if (empty($content)) {
            $content = '<p>Nenhuma opção de envio disponível para seu endereço.</p>';
        }

        return new Response(['body' => \GuzzleHttp\json_encode([
            'content' => $content
        ])]);
    }

    public function getTotal()
    {
        $total = $this->Cart->getTotal();
        $this->set(compact('total'));
        $this->set('_serialize', ['total']);
    }
}