<?php

namespace Api\Controller;

use Cake\ORM\TableRegistry;

/**
 * Customers Controller
 *
 * @property \Checkout\Model\Table\CustomersTable $Customers
 */
class CustomersController extends \Theme\Controller\AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Customers = TableRegistry::getTableLocator()->get('Checkout.Customers');
        $this->Auth->allow(['validateToken', 'refreshToken']);
    }

    /**
     * @param $token
     */
    public function validateToken($token)
    {
        $customer = $this->Customers->validateToken($token);
        $this->set(compact('customer'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * @param $token
     * @throws \Exception
     */
    public function refreshToken($token)
    {
        $response = $this->Customers->refreshToken($token);
        if (!$response) {
            $token = false;
        } else {
            $token = $response['token'];
            unset($response['customer']->password);
            $this->Auth->setUser($response['customer']);
        }
        $this->set(compact('token'));
        $this->set('_serialize', ['token']);
    }

}
