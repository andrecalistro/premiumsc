<?php

namespace CheckoutV2\Controller\Component;

use Admin\Model\Entity\DiscountsGroup;
use Admin\Model\Table\DiscountsGroupsTable;
use Admin\Model\Table\StoresTable;
use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Checkout\Model\Entity\Order;

/**
 * Class OrderComponent
 * @package App\Controller\Component
 *
 * @property \Checkout\Controller\Component\CartComponent $Cart
 *
 * @property \Checkout\Model\Table\CustomersTable $Customers
 * @property \Checkout\Model\Table\CustomersAddressesTable $CustomersAddresses
 * @property \Checkout\Model\Table\OrdersTable $Orders
 */
class OrderComponent extends Component
{
    public $Orders;
    public $components = ['Cart', 'Pagseguro'];
    public $payment_config;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Orders = TableRegistry::getTableLocator()->get('CheckoutV2.Orders');

        if (isset($config['payment_config'])) {
            $this->payment_config = $config['payment_config'];
        }
    }

    /**
     * @param $customers_id
     * @param $session_id
     * @param array $options
     * @return bool|\Checkout\Model\Entity\Order
     */
    public function addNewOrderEmpty($customers_id, $session_id, array $options = [])
    {
        $cart = $this->Cart->getProducts($session_id);
        $data = [
            'customers_id' => $customers_id,
            'orders_statuses_id' => 0,
            'subtotal' => $cart['subtotal'],
            'shipping_total' => $cart['quote_price'],
            'total' => $cart['total'],
            'ip' => $this->getController()->request->clientIp()
        ];

        if (!empty($options)) {
            $data = array_merge($data, $options);
        }

        foreach ($cart['products'] as $product) {
            $data_product = [
                'products_id' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'price' => $product->unit_price,
                'price_total' => $product->total_price,
                'price_special' => $product->price_special > 0 ? $product->price : 0,
                'image_thumb' => $product->thumb_main_image,
                'image' => $product->main_image
            ];

            if ($product->variation) {
                $data_product += [
                    'orders_products_variations' => [[
                        'products_id' => $product->id,
                        'quantity' => $product->quantity,
                        'variations_id' => $product->variation->id,
                        'variations_sku' => $product->variations_sku
                    ]]
                ];
            }
            $data['orders_products'][] = $data_product;
        }

        //check coupon exists
        if ($this->getController()->request->getSession()->check('Coupon.id')) {
            $data['coupons_id'] = $this->getController()->request->getSession()->read('Coupon.id');
            $data['coupon_discount'] = $this->getController()->request->getSession()->read('Coupon.discount');
        }

        /**
         * check orders exists in session
         */
        if ($this->getController()->request->getSession()->check('orders_id')) {
            $order = $this->Orders->get($this->getController()->request->getSession()->read('orders_id'), [
                'contain' => [
                    'OrdersProducts' => function ($q) {
                        return $q->contain(['OrdersProductsVariations']);
                    }
                ]

            ]);
            $order = $this->Orders->patchEntity($order, ['contain' => 'OrdersProducts'], $data, [
                'associated' => [
                    'OrdersProducts' => [
                        'associated' => [
                            'OrdersProductsVariations' => ['validate' => false]
                        ]
                    ]
                ]
            ]);
        } else {
            $order = $this->Orders->newEntity($data, [
                'associated' => [
                    'OrdersProducts' => [
                        'associated' => [
                            'OrdersProductsVariations' => ['validate' => false]
                        ]
                    ]
                ]
            ]);
        }

        if ($this->Orders->save($order)) {
            $this->getController()->request->getSession()->write('orders_id', $order->id);
            return $order;
        }
        return false;
    }

    /**
     * @param $orders_id
     * @param $addresses_id
     * @return bool|\Checkout\Model\Entity\Order
     */
    public function addAddress($orders_id, $addresses_id)
    {
        $order = $this->Orders->get($orders_id);
        $address = $this->Orders->CustomersAddresses->get($addresses_id, [
            'fields' => [
                'customers_addresses_id' => 'id',
                'address',
                'number',
                'complement',
                'zipcode',
                'neighborhood',
                'city',
                'state'
            ]
        ])->toArray();
        $order = $this->Orders->patchEntity($order, $address);
        if ($this->Orders->save($order)) {
            return $order;
        }
        return false;
    }

    /**
     * @param $data
     * @param $orders_id
     * @return bool
     */
    public function update($data, $orders_id)
    {
        $order = $this->Orders->get($orders_id);
        $order = $this->Orders->patchEntity($order, $data);
        if ($this->Orders->save($order)) {
            return true;
        }
        return false;
    }

    /**
     * @param $orders_id
     * @return bool|mixed
     */
    public function delete($orders_id = null)
    {
        if (!is_null($orders_id) && $this->Orders->exists(['id' => $orders_id])) {
            $order = $this->Orders->get($orders_id, [
                'contain' => ['OrdersProducts']
            ]);
            if ($this->Orders->delete($order)) {
                Component::getController()->request->getSession()->delete('orders_id');
                return true;
            }
        }
        return false;
    }

    /**
     * @param null $orders_id
     * @return bool|\Checkout\Model\Entity\Order
     */
    public function getOrder($orders_id = null)
    {
        if (!$this->Orders->exists(['id' => $orders_id])) {
            return false;
        }

        return $this->Orders->get($orders_id, [
            'contain' => [
                'OrdersProducts' => [
                    'Products' => [
                        'ProductsImages'
                    ],
                    'OrdersProductsVariations' => [
                        'Variations' => [
                            'VariationsGroups'
                        ]
                    ]
                ],
                'Customers',
                'Coupons',
                'PaymentsMethods'
            ]
        ]);
    }

    /**
     * @param $orders_id
     * @param $orders_statuses_id
     * @param null $comment
     * @param bool $notify
     * @return bool
     */
    public function addHistory($orders_id, $orders_statuses_id, $comment = null, $notify = false)
    {
        $order = $this->Orders->get($orders_id);
        $order = $this->Orders->patchEntity($order, ['orders_statuses_id' => $orders_statuses_id]);
        if ($this->Orders->save($order)) {
            $history = $this->Orders->OrdersHistories->newEntity([
                'orders_id' => $orders_id,
                'orders_statuses_id' => $orders_statuses_id,
                'comment' => $comment,
                'notify_customer' => $notify
            ]);
            if ($this->Orders->OrdersHistories->save($history)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $payment_config
     * @param $price
     * @return array
     */
    public function installments($payment_config, $price)
    {
        $installments = [];
        $interest = str_replace(',', '.', $payment_config->interest) / 100;
        if ($price < $payment_config->installment_min) {
            $installments[1] = '1x de ' . 'R$ ' . number_format($price, 2, ",", ".") . ' sem juros';
        } else {
            for ($i = 1; $i <= $payment_config->installment; $i++) {
                if ($i <= $payment_config->installment_free) {
                    $price_without_installment = ($price / $i);
                    if ($price_without_installment >= $payment_config->installment_min) {
                        $installments[$i] = $i . 'x de ' . 'R$ ' . number_format($price_without_installment, 2, ",", ".") . ' sem juros';
                    }
                } else {
                    $price_with_installment = $price / ((1 - pow((1 - $interest), $i)) / $interest);
                    if ($price_with_installment >= $payment_config->installment_min) {
                        $installments[$i] = $i . 'x de ' . 'R$ ' . number_format($price_with_installment, 2, ",", ".") . ' com juros';
                    }
                }
            }
        }
        return $installments;
    }

    /**
     * @param $orders_id
     * @param $method
     * @return array
     */
    public function discount($orders_id, $method)
    {
        /** @var Order $order */
        $order = $this->getOrder($orders_id);

        $discount = 0;
        $discount_total = 0;
        $subtotal = $order->subtotal;
        $total = $subtotal + $order->shipping_total - $order->coupon_discount;
        $discount_text = '';
        $status = false;
        $data = [
            'total' => $total,
            'total_without_discount' => $subtotal + $order->shipping_total,
            'discount' => 0,
            'discount_percent' => 0
        ];
        $discounts = [];

        if (preg_match('/ticket/', $method)) {

            if (isset($this->payment_config->ticket_discount) && is_numeric($this->payment_config->ticket_discount) && $this->payment_config->ticket_discount > 0) {
                $discount = (($this->payment_config->ticket_discount / 100) * $subtotal);
                $discount_total += $discount;
                $discount_text = $this->payment_config->ticket_discount . '% de desconto no boleto';
                $discounts[] = [
                    'discount' => 'R$ ' . number_format($discount, 2, ",", "."),
                    'discount_percent' => $this->payment_config->ticket_discount,
                    'discount_text' => $discount_text
                ];
                $status = true;
            }
        }

        if (preg_match('/debit-card/', $method)) {
            if (isset($this->payment_config->ticket_discount) && is_numeric($this->payment_config->ticket_discount) && $this->payment_config->ticket_discount > 0) {
                $discount = (($this->payment_config->ticket_discount / 100) * $total);
                $total = $subtotal - $discount - $order->coupon_discount + $order->shipping_total;
                $discount_text = $this->payment_config->ticket_discount . '% de desconto no débito';
                $data = [
                    'total' => $total,
                    'total_without_discount' => $subtotal + $order->shipping_total,
                    'discount' => $discount,
                    'discount_percent' => $this->payment_config->ticket_discount
                ];
                $status = true;
            }
        }

        /** @var DiscountsGroup $discountGroup */
        if ($discountGroup = $this->getDiscountGroup($order->customers_id)) {
            $discount = 0;
            $subtotal = $order->subtotal;
            $total = $subtotal + $order->shipping_total - $order->coupon_discount;
            $discount_text = '';

            if ($discountGroup->type === 'fixed') {
                $discount = $discountGroup->discount > $subtotal ? $subtotal : $discountGroup->discount;
                $total = $subtotal - $discount - $order->coupon_discount + $order->shipping_total;
                $discount_text = 'R$ ' . number_format($discount, 2, ',', '.') . ' de desconto por ser do grupo ' . $discountGroup->name;
                $data = [
                    'total' => $total,
                    'total_without_discount' => $subtotal + $order->shipping_total,
                    'discount' => $discount,
                    'discount_percent' => $this->payment_config->ticket_discount
                ];
                $status = true;
            }

            if ($discountGroup->type === 'percentage') {
                $discount = (($discountGroup->discount / 100) * $total);
                $total = $subtotal - $discount - $order->coupon_discount + $order->shipping_total;
                $discount_text = number_format($discountGroup->discount, 0) . '% de desconto por ser do grupo ' . $discountGroup->name;
                $data = [
                    'total' => $total,
                    'total_without_discount' => $subtotal + $order->shipping_total,
                    'discount' => $discount,
                    'discount_percent' => $discountGroup->discount
                ];
                $status = true;
            }
        }

        if ($discountFirstPurchase = $this->getDiscountFirstPurchase($order->customers_id, $order->id)) {
            $discount = 0;
            $subtotal = $order->subtotal;
            $discount_text = '';
            $discount_percent = '';

            if ($discountFirstPurchase->discount_type === 'fixed') {
                $discount = $discountFirstPurchase->discount > $subtotal ? $subtotal : $discountFirstPurchase->discount;
                $discount_total += $discount;
                $discount_text = 'Desconto primeira compra';
                $status = true;
            }

            if ($discountFirstPurchase->discount_type === 'percentage') {
                $discount = (($discountFirstPurchase->discount / 100) * $subtotal);
                $discount_total += $discount;
                $discount_text = number_format($discountFirstPurchase->discount, 0) . '% de desconto primeira compra';
                $discount_percent = $discountFirstPurchase->discount;
                $status = true;
            }

            $discounts[] = [
                'discount' => 'R$ ' . number_format($discount, 2, ",", "."),
                'discount_percent' => $discount_percent,
                'discount_text' => $discount_text
            ];
        }

        $total = ($subtotal - $discount_total) + $order->shipping_total - $order->coupon_discount;
        $discount_percent = number_format((($discount_total * 100) / $subtotal), 0);

        $data = [
            'total' => $total,
            'total_without_discount' => $subtotal + $order->shipping_total,
            'discount' => $discount_total,
            'discount_percent' => $discount_percent
        ];

        if ($status) {
            $order = $this->Orders->patchEntity($order, $data);
            $this->Orders->save($order);
        }

        return [
            'status' => $status,
            'total' => $total,
            'total_format' => 'R$ ' . number_format($total, 2, ",", "."),
            'discounts' => $discounts
        ];
    }

    /**
     * set, if exist, coupon how used
     */
    public function finalizeOrder()
    {
        $order = $this->Orders->get($this->getController()->request->getSession()->read('orders_id'), [
            'contain' => 'Coupons'
        ]);
        if ($order->coupon) {
            $coupon = $this->Orders->Coupons->get($order->coupons_id);
            $coupon = $this->Orders->Coupons->patchEntity($coupon, ['used_limit' => $coupon->used_limit + 1]);
            $this->Orders->Coupons->save($coupon);
        }
        return true;
    }

    /**
     * @return array
     */
    public function shippingIsRequired()
    {
        $order = $this->getOrder($this->getController()->request->getSession()->read('orders_id'));
        return Hash::extract($order->orders_products, '{n}.product[shipping_control=1]');
    }

    /**
     * @param bool $need
     */
    public function setOrderNeedShipping($need = true)
    {
        $order = $this->getOrder($this->getController()->request->getSession()->read('orders_id'));
        $order->shipping_total = 0;
        $order->shipping_text = null;
        $order->shipping_code = null;
        $order->shipping_deadline = null;
        $order->shipping_image = null;
        if ($need) {
            $order->shipping_required = 1;
        } else {
            $order->shipping_required = 0;
        }
        $this->Orders->save($order);
    }

    /**
     * @param $customerId
     * @return array|bool|\Cake\Datasource\EntityInterface|null
     */
    private function getDiscountGroup($customerId)
    {
        /** @var StoresTable $storeTable */
        $storeTable = TableRegistry::getTableLocator()->get('Admin.Stores');

        $discountGroupConfig = $storeTable->findConfig('discount_group');

        if (\count((array)$discountGroupConfig) === 0) {
            return false;
        }

        /** @var DiscountsGroupsTable $discountGroupTable */
        $discountGroupTable = TableRegistry::getTableLocator()->get('Admin.DiscountsGroups');

        $discountGroup = $discountGroupTable->find()
            ->join([
                'dgc' => [
                    'table' => 'discount_group_customers',
                    'type' => 'INNER',
                    'conditions' => 'dgc.discounts_groups_id = DiscountsGroups.id'
                ]
            ])
            ->where([
                'dgc.customers_id' => $customerId
            ])
            ->first();

        if (!$discountGroup) {
            return false;
        }

        return $discountGroup;
    }

    /**
     * @param $cost
     * @param $orderId
     * @return float
     */
    public function calcShippingCostDiscountGroup($cost, $orderId)
    {
        /** @var Order $order */
        $order = $this->getOrder($orderId);

        /** @var DiscountsGroup|null|bool $discountGroup */
        $discountGroup = $this->getDiscountGroup($order->customers_id);

        if ($discountGroup && $discountGroup->free_shipping) {
            return 0.00;
        }

        return $cost;
    }

    /**
     * @param $customerId
     * @param $orderId
     * @return bool|\stdClass
     */
    private function getDiscountFirstPurchase($customerId, $orderId)
    {
        /** @var StoresTable $storeTable */
        $storeTable = TableRegistry::getTableLocator()->get('Admin.Stores');

        $discountConfig = $storeTable->findConfig('discount_first_purchase');

        if (!count((array)$discountConfig)) {
            return false;
        }

        $orders = $this->Orders->find()
            ->where([
                'customers_id' => $customerId,
                'id <>' => $orderId,
                'orders_statuses_id NOT IN' => [0, 6],
            ])
            ->toArray();

        if (\count($orders)) {
            return false;
        }

        $discountConfig->discount = str_replace('.','', $discountConfig->discount);
        $discountConfig->discount = str_replace(',','.', $discountConfig->discount);

        $discountConfig->min = str_replace('.','', $discountConfig->min);
        $discountConfig->min = str_replace(',','.', $discountConfig->min);

        $discountConfig->max = str_replace('.','', $discountConfig->max);
        $discountConfig->max = str_replace(',','.', $discountConfig->max);

        return $discountConfig;
    }

}