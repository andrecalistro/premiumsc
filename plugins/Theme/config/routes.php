<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Theme',
    ['path' => '/'],
    function (RouteBuilder $routes) {
        $routes->extensions(['json', 'xml', 'ajax']);
        $routes->fallbacks(DashedRoute::class);

        /**
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, src/Template/Pages/home.ctp)...
         */
        $routes->connect('/', ['controller' => 'home', 'action' => 'index']);

        /**
         * Product
         */
        $routes->connect('/produto/:slug/:id', ['controller' => 'products', 'action' => 'view'], ['pass' => ['id']]);
        $routes->connect('/produto/:slug_category/:slug/:id', ['controller' => 'products', 'action' => 'view'], ['pass' => ['id']]);
        $routes->connect('/produtos', ['controller' => 'products', 'action' => 'all']);

        /**
         * Categories
         */
        $routes->connect('/departamento/:slug/:id', ['controller' => 'categories', 'action' => 'view'], [
            '_name' => 'category',
            'slug' => '[^\/]+',
            'id' => '[0-9]+',
            'pass' => ['id']
        ]);
        $routes->connect('/busca/:param', ['controller' => 'products', 'action' => 'search'], [
            '_name' => 'search',
            'param' => '[^\/]+',
            'pass' => ['param']
        ]);

        /**
         * Filters
         */
        $routes->connect('/filtro/:slug/:id', ['controller' => 'filters', 'action' => 'view'], ['pass' => ['id']]);

        /**
         * Pages
         */
		$routes->connect('/pagina/:slug', ['controller' => 'pages', 'action' => 'view'], ['slug' => '[^\/]+', '_name' => 'pages', 'pass' => ['slug']]);
		$routes->connect('/atendimento', ['controller' => 'pages', 'action' => 'contact']);
        $routes->connect('/fale-conosco', ['controller' => 'pages', 'action' => 'contact']);
		$routes->connect('/conceito', ['controller' => 'pages', 'action' => 'concept']);
		$routes->connect('/onde-encontrar', ['controller' => 'pages', 'action' => 'where-find']);
		$routes->connect('/seja-um-licenciado', ['controller' => 'pages', 'action' => 'partner']);
		$routes->connect('/linha-profissional', ['controller' => 'pages', 'action' => 'professionalLine']);

        /**
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
    }
);
