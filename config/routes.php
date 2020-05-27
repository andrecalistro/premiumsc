<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::scope('/admin/integrators', ['plugin' => 'integrators'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
    $routes->connect('/', ['controller' => 'Integrators', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

Router::scope('/admin/subscriptions', ['plugin' => 'subscriptions'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
    $routes->connect('/', ['controller' => 'DirectsMails', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

Router::scope('/admin/ufo', ['plugin' => 'ufo-admin'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
    $routes->fallbacks(DashedRoute::class);

    $routes->connect('/orders', ['controller' => 'orders', 'action' => 'index'], [
        '_name' => 'orders_ufo'
    ]);
});

Router::scope('/integrators', ['plugin' => 'integrators'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
    $routes->connect('/', ['controller' => 'Integrators', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

Router::scope('/api', ['plugin' => 'api'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'ajax']);
    $routes->connect('/', ['controller' => 'Categories', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

Router::scope('/email-api', ['plugin' => 'email'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'ajax']);
    $routes->connect('/', ['controller' => 'Emails', 'action' => 'index']);
    $routes->fallbacks(DashedRoute::class);
});

Router::scope('/admin', ['plugin' => 'admin'], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
    $routes->fallbacks(DashedRoute::class);
});

//if (\Cake\Core\Configure::read('activePluginCheckoutV2')) {
    Router::scope('/carrinho', ['plugin' => 'CheckoutV2'], function (RouteBuilder $routes) {
        $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
        $routes->connect('/', ['controller' => 'Carts', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    });

    Router::scope('/finalizar-compra', ['plugin' => 'CheckoutV2'], function (RouteBuilder $routes) {
        $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
        $routes->connect('/', ['controller' => 'Checkout', 'action' => 'identify']);
        $routes->fallbacks(DashedRoute::class);
    });

    Router::scope('/minha-conta', ['plugin' => 'CheckoutV2'], function (RouteBuilder $routes) {
        $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
        $routes->connect('/', ['controller' => 'Customers', 'action' => 'dashboard']);
        $routes->fallbacks(DashedRoute::class);
    });

    Router::scope('/checkout', ['plugin' => 'CheckoutV2'], function (RouteBuilder $routes) {
        $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
        $routes->connect('/', ['controller' => 'Carts', 'action' => 'index']);
        $routes->fallbacks(DashedRoute::class);
    });

    Router::scope('/l/*', ['plugin' => 'CheckoutV2'], function (RouteBuilder $routes) {
        $routes->setExtensions(['json', 'xml', 'ajax', 'pdf']);
        $routes->fallbacks(DashedRoute::class);
    });
//}

Router::scope('/', ['plugin' => \Cake\Core\Configure::read('Theme')], function (RouteBuilder $routes) {
    $routes->setExtensions(['json', 'xml', 'ajax']);
    $routes->fallbacks(DashedRoute::class);
});