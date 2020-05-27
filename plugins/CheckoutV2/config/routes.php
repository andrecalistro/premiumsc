<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'CheckoutV2',
    ['path' => '/carrinho'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json', 'ajax']);
        /**
         * Cart
         */
        $routes->connect('/', ['controller' => 'Carts', 'action' => 'index']);
        $routes->connect('/remover/:id', ['controller' => 'Carts', 'action' => 'delete'], ['pass' => ['id']]);
        $routes->connect('/adicionar', ['controller' => 'Carts', 'action' => 'add', '_ext' => 'json']);
        $routes->connect('/incrementar/:id', ['controller' => 'Carts', 'action' => 'increment'], ['pass' => ['id']]);
        $routes->connect('/decrementar/:id', ['controller' => 'Carts', 'action' => 'decrement'], ['pass' => ['id']]);
        $routes->connect('/calcular-frete', ['controller' => 'Carts', 'action' => 'quote']);
        $routes->connect('/selecionar-frete', ['controller' => 'Carts', 'action' => 'quote-chosen']);
        $routes->connect('/alterar-quantidade/:id/:quantity', ['controller' => 'Carts', 'action' => 'change-quantity'], ['pass' => ['id', 'quantity']]);
        $routes->connect(
            '/pagseguro-notificacao',
            ['controller' => 'pagseguro-credit-card', 'action' => 'notification'],
            ['_name' => 'pagseguro_notificacao', 'ext' => 'json']
        );
    }
);

Router::plugin(
    'CheckoutV2',
    ['path' => '/minha-conta'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json', 'ajax']);
        /**
         * Customer
         */
        $routes->connect('/', ['controller' => 'customers', 'action' => 'dashboard']);
        $routes->connect('/login', ['controller' => 'customers', 'action' => 'login'], ['_name' => 'customer_login']);
        $routes->connect('/meus-dados', ['controller' => 'customers', 'action' => 'account']);
        $routes->connect('/meus-pedidos', ['controller' => 'customers', 'action' => 'orders']);
        $routes->connect('/acesso-cadastro', ['controller' => 'customers', 'action' => 'register']);
        $routes->connect('/alterar-senha', ['controller' => 'customers', 'action' => 'change-password']);
        $routes->connect('/esqueci-minha-senha', ['controller' => 'customers', 'action' => 'lost-password']);
        $routes->connect('/meu-pedido/:id', ['controller' => 'customers', 'action' => 'order'], ['pass' => ['id']]);
        $routes->connect('/sair', ['controller' => 'customers', 'action' => 'logout']);
        $routes->connect('/completar-cadastro', ['controller' => 'customers', 'action' => 'complete-register'], ['_name' => 'customer_register']);

        /**
         * Customer Address
         */
        $routes->connect('/meus-enderecos', ['controller' => 'customers-addresses']);
        $routes->connect('/meus-enderecos', ['controller' => 'customers-addresses', 'action' => 'index']);
        $routes->connect('/adicionar-endereco', ['controller' => 'customers-addresses', 'action' => 'add']);
        $routes->connect('/editar-endereco/:id', ['controller' => 'customers-addresses', 'action' => 'edit'], ['pass' => ['id']]);
        $routes->connect('/excluir-endereco/:id', ['controller' => 'customers-addresses', 'action' => 'delete'], ['pass' => ['id']]);

        /**
         * Subscriptions
         */
        $routes->connect('/minhas-assinaturas', ['controller' => 'customer-subscriptions', 'action' => 'index'], ['_name' => 'customerSubscriptions']);
        $routes->connect('/minha-assinatura/:id', ['controller' => 'customer-subscriptions', 'action' => 'view'], ['_name' => 'customerSubscriptionView', 'pass' => ['id']]);
    }
);

Router::plugin(
    'CheckoutV2',
    ['path' => '/finalizar-compra'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json', 'ajax']);
        /**
         * CheckoutV2
         */
        $routes->connect('/identificacao', ['controller' => 'checkout', 'action' => 'identification']);
        $routes->connect('/login/:login', ['controller' => 'checkout', 'action' => 'login'], ['pass' => ['login']]);
        $routes->connect('/adicionar-endereco', ['controller' => 'checkout', 'action' => 'add-address']);
        $routes->connect('/forma-de-envio/:id', ['controller' => 'checkout', 'action' => 'shipment'], ['pass' => ['id']]);
        $routes->connect('/selecionar-pagamento', ['controller' => 'checkout', 'action' => 'choose-payment']);
        $routes->connect('/pagamento', ['controller' => 'checkout', 'action' => 'payment']);
        $routes->connect('/escolher-endereco', ['controller' => 'checkout', 'action' => 'choose-address']);
        $routes->connect('/cadastro', ['controller' => 'checkout', 'action' => 'register']);
		$routes->connect('/limpar-endereco', ['controller' => 'checkout', 'action' => 'clear-address']);
        $routes->connect('/pedido-confirmado/:id', ['controller' => 'checkout', 'action' => 'success'], ['pass' => ['id']]);
        $routes->connect('/carregar-pagamento', ['controller' => 'checkout', 'action' => 'get-payment-html']);
    }
);

Router::plugin(
    'CheckoutV2',
    ['path' => '/l/*'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json', 'ajax']);

        $routes->connect('/', ['controller' => 'wish-lists', 'action' => 'view']);
    }
);

Router::plugin(
    'CheckoutV2',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
        $routes->setExtensions(['json', 'ajax']);

        $routes->connect('/newsletter', ['controller' => 'customers', 'action' => 'emails-marketings']);
    }
);
