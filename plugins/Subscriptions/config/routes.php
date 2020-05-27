<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Subscriptions',
    ['path' => '/subscriptions'],
    function (RouteBuilder $routes) {
        $routes->setExtensions(['json', 'xml', 'ajax']);
        $routes->fallbacks(DashedRoute::class);

        /**
         * Checkout
         */
        $routes->connect('/plano/adicionar-carrinho/:id', ['controller' => 'plan-checkout', 'action' => 'add-plan-cart'], ['pass' => ['id'], '_name' => 'planAddCart']);

        $routes->connect('/plano/identificacao', ['controller' => 'plan-checkout', 'action' => 'identification'], ['_name' => 'planIdentification']);

        $routes->connect('/plano/checar-cadastro', ['controller' => 'plan-checkout', 'action' => 'check-register'], ['_name' => 'planCheckRegister']);

        $routes->connect('/plano/cadastro', ['controller' => 'plan-checkout', 'action' => 'register'], ['_name' => 'planRegister']);

        $routes->connect('/plano/forma-de-envio/:id', ['controller' => 'plan-checkout', 'action' => 'shipment'], ['pass' => ['id'], '_name' => 'planShipment']);

        $routes->connect('/plano/pagamento', ['controller' => 'plan-checkout', 'action' => 'payment'], ['_name' => 'planPayment']);

        $routes->connect('/plano/escolher-endereco', ['controller' => 'plan-checkout', 'action' => 'choose-address'], ['_name' => 'planChooseAddress']);
        $routes->connect('/plano/adicionar-endereco', ['controller' => 'plan-checkout', 'action' => 'add-address'], [
            '_name' => 'planAddAddress'
        ]);
        $routes->connect('/plano/cadastro', ['controller' => 'plan-checkout', 'action' => 'register']);
        $routes->connect('/plano/limpar-endereco', ['controller' => 'plan-checkout', 'action' => 'clear-address']);
        $routes->connect('/plano/pedido-confirmado/:id', ['controller' => 'plan-checkout', 'action' => 'success'], ['pass' => ['id']]);
        $routes->connect('/plano/carregar-pagamento', ['controller' => 'plan-checkout', 'action' => 'get-payment-html'], ['_name' => 'planGetPaymentHtml']);
        $routes->connect('/plano/pagamento/processar', ['controller' => 'plan-checkout', 'action' => 'process-payment'], ['_name' => 'planProcessPayment']);
        $routes->connect('/plano/finalizado/:id', ['controller' => 'plan-checkout', 'action' => 'success'], ['pass' => ['id'], '_name' => 'planSuccess']);
        $routes->connect('/plano/checar-status-pagamentos', ['controller' => 'plan-checkout', 'action' => 'check-status-payment'], ['_name' => 'planCheckStatusPayment']);
        $routes->connect('/plano/processar-proximos-pagamentos', ['controller' => 'plan-checkout', 'action' => 'process-next-payment'], ['_name' => 'planProcessNextPayment']);
        $routes->connect('/plano/cancelar-assinatura', ['controller' => 'plan-checkout', 'action' => 'cancel'], ['_name' => 'planCancelSubscription']);
    }
);
