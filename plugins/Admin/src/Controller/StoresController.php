<?php

namespace Admin\Controller;

use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\I18n\Number;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\I18n\Time;

/**
 * Stores Controller
 *
 * @property \Admin\Model\Table\StoresTable $Stores
 * @property \Admin\Controller\Component\AnalyticsComponent $Analytics
 */
class StoresController extends AppController
{

    /**
     * Index Method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $result = $this->Stores->findConfig('store');
        $entity = (object)[
            'name' => '',
            'document' => '',
            'telephone' => '',
            'cellphone' => '',
            'logo' => '',
            'favicon' => '',
            'icon' => '',
            'zipcode' => '',
            'address' => '',
            'number' => '',
            'complement' => '',
            'neighborhood' => '',
            'city' => '',
            'state' => '',
            'email_notification' => '',
            'email_contact' => '',
            'status_new_order' => '',
            'status_completed_order' => '',
            'seo_title' => '',
            'seo_description' => '',
            'google_analytics' => '',
            'facebook' => '',
            'instagram' => '',
            'twitter' => '',
            'terms_pages_id' => 0,
            'google_recaptcha_site_key' => '',
            'google_recaptcha_secret_key' => '',
            'google_analytics_ecommerce_status' => 0,
            'facebook_pixel' => '',
            'blog_url' => '',
            'analytics_account_id' => '',
            'analytics_property_id' => '',
            'orders_statuses_config' => '',
            'additional_scripts_header' => '',
            'additional_scripts_footer' => '',
            'sender_address' => '',
            'due_days' => 10
        ];
        $store = $this->Stores->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), 'store');
            $entities = $this->Stores->newEntities($data);
            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações da Loja foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações da Loja não foram salvas. Por favor, tente novamente."));
            }
        }
        $OrdersStatuses = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');

        $ordersStatuses = $OrdersStatuses->find('list');

        if (!empty($store->logo)) {
            $store->thumb_logo_link = Router::url("img" . DS . "files" . DS . "Stores" . DS . "thumbnail-" . $store->logo, true);
        }

        if (!empty($store->favicon)) {
            $store->thumb_favicon_link = Router::url("img" . DS . "files" . DS . "Stores" . DS . "thumbnail-" . $store->favicon, true);
        }

        if (!empty($store->icon)) {
            $store->thumb_icon_link = Router::url("img" . DS . "files" . DS . "Stores" . DS . "thumbnail-" . $store->icon, true);
        }

        $Pages = TableRegistry::getTableLocator()->get('Admin.Pages');
        $pages = $Pages->find('list')->toArray();

        $ProductsStatuses = TableRegistry::getTableLocator()->get('Admin.ProductsStatuses');
        $productsStatuses = $ProductsStatuses->find('list');
        $stockControl = ['neutral' => 'Não alterar', 'up' => 'Subir estoque', 'down' => 'Baixar estoque'];

        $this->set(compact('store', 'ordersStatuses', 'pages', 'productsStatuses', 'stockControl'));
        $this->set('_serialize', 'store');
    }

    /**
     *
     */
    public function dashboard()
    {
        $result = $this->Stores->findConfig('store');
        $entity = (object)[
            'analytics_account_id' => '',
            'analytics_property_id' => '',
        ];
        $store = $this->Stores->mapFindConfig($entity, $result);

        $Orders = TableRegistry::getTableLocator()->get('Admin.Orders');

        if ($store->analytics_account_id && $store->analytics_property_id) {
            $this->loadComponent('Admin.Analytics');
            $profileId = $this->Analytics->getFirstProfileIdByProperty($store->analytics_account_id, $store->analytics_property_id);
            $userStats = $this->Analytics->getUsersNumbers($profileId);

            $ordersToday = $Orders->OrdersPerDay(2, 0, new Time('today', 'America/Sao_Paulo'));
            $ordersWeek = $Orders->OrdersPerDay(2, 7, new Time('today', 'America/Sao_Paulo'));
            $ordersMonth = $Orders->OrdersPerDay(2, 30, new Time('today', 'America/Sao_Paulo'));

            $conversionTaxes['today'] = Number::precision((100 * $ordersToday['count_total']) / $userStats['today'], 2);
            $conversionTaxes['week'] = Number::precision((100 * $ordersWeek['count_total']) / $userStats['week'], 2);
            $conversionTaxes['month'] = Number::precision((100 * $ordersMonth['count_total']) / $userStats['month'], 2);
        } else {
            $userStats = $conversionTaxes = [
                'today' => 0,
                'week' => 0,
                'month' => 0,
            ];
        }

        $orders = $Orders->OrdersPerDay(2, 6, Date::now('America/Sao_Paulo'));

        $OrdersProducts = TableRegistry::getTableLocator()->get('Admin.OrdersProducts');
        $bestSellers = $OrdersProducts->bestSellers(3);

        $Customers = $this->loadModel('Admin.Customers');
        $customers = $Customers->newCustomers();

        $ProductsSearches = TableRegistry::getTableLocator()->get('Admin.ProductsSearches');
        $searches = $ProductsSearches->topSearches(3);

        $CategoriesVisitors = TableRegistry::getTableLocator()->get('Admin.CategoriesVisitors');
        $categories = $CategoriesVisitors->topVisitors(6);

        $this->set(compact('orders', 'customers', 'searches', 'categories', 'conversionTaxes', 'bestSellers'));
    }

    public function main()
    {
        $result = $this->Stores->findConfig('main');
        $entity = (object)[
            'template_product_form' => 'default',
            'api_token' => '',
            'company_register' => 0
        ];
        $main = $this->Stores->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), 'main');
            $entities = $this->Stores->newEntities($data);
            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações foram salvas."));
                return $this->redirect(['action' => 'main']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }
        $statuses = [0 => 'Não', 1 => 'Sim'];

        $this->set(compact('main', 'statuses'));
        $this->set('_serialize', 'main');
    }

    /**
     *
     */
    public function generateApiToken()
    {
        $token = $this->Stores->generateApiToken();
        $this->set(compact('token'));
        $this->set('_serialize', ['token']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function clearCache() {
        Cache::clear(false);
        $this->Flash->success(__("Cache do framework limpo com sucesso."));
        return $this->redirect(['action' => 'index']);
    }
}
