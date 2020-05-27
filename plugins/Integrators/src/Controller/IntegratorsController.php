<?php

namespace Integrators\Controller;

/**
 * Class IntegratorsController
 * @package Admin\Controller
 */
class IntegratorsController extends \Admin\Controller\AppController
{
    public function index()
    {
        $integrators = [
            [
                'name' => 'Bling',
                'controller' => 'bling',
                'action' => 'index'
            ],
            [
                'name' => 'Google Shopping',
                'controller' => 'google-shopping',
                'action' => 'index'
            ],
            [
                'name' => 'Melhor envio',
                'controller' => 'api-best-shipping',
                'action' => 'index'
            ]
        ];
        $this->set(compact('integrators'));
    }
}
