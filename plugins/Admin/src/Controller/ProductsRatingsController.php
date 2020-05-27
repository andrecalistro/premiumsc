<?php

namespace Admin\Controller;

use Admin\Controller\AppController;
use Admin\Model\Table\StoresTable;
use Cake\ORM\TableRegistry;

/**
 * ProductsRatings Controller
 *
 * @property \Admin\Model\Table\ProductsRatingsTable $ProductsRatings
 *
 * @method \Admin\Model\Entity\ProductsRating[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsRatingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $filter = [
            'orders_id' => '',
            'customer' => '',
            'product' => '',
            'rating' => '',
            'created' => '',
            'statuses' => ''
        ];

        $this->paginate = [
            'contain' => ['Customers', 'Orders', 'Products', 'ProductsRatingsStatuses']
        ];
        $productsRatings = $this->paginate($this->ProductsRatings);

        $statuses = $this->ProductsRatings->ProductsRatingsStatuses->find('list')
            ->toArray();

        $this->set(compact('productsRatings', 'statuses', 'filter'));
    }

    /**
     * View method
     *
     * @param string|null $id Products Rating id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.w
     */
    public function view($id = null)
    {
        $productsRating = $this->ProductsRatings->get($id, [
            'contain' => ['Customers', 'Orders', 'Products', 'ProductsRatingsStatuses']
        ]);

        $this->set('productsRating', $productsRating);
    }

    /**
     *
     */
    public function setStatus()
    {
        $productRatingId = $this->request->getData('productRatingId');

        $productRating = $this->ProductsRatings->get($productRatingId);
        $productRating->products_ratings_statuses_id = $this->request->getData('status');
        $status = $this->ProductsRatings->save($productRating);

        $this->set('status', $status);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function configure()
    {
        /** @var StoresTable $StoresTable */
        $StoresTable = TableRegistry::getTableLocator()->get('Admin.Stores');

        $result = $StoresTable->findConfig('product_rating');
        $entity = (object)[
            'status' => 0,
            'orders_statuses_id' => null,
            'days' => 5
        ];

        $config = $StoresTable->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $StoresTable->prepareSave($this->request->getData(), 'product_rating');
            $entities = $StoresTable->newEntities($data);
            if ($StoresTable->saveMany($entities)) {
                $this->Flash->success(__("Configurações de avaliações do produto foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações de avaliações do produto não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [1 => 'Habilitado', 0 => 'Desabilitado'];

        $OrdersStatusesTable = TableRegistry::getTableLocator()->get('Admin.OrdersStatuses');
        $ordersStatuses = $OrdersStatusesTable->find('list')
            ->order(['OrdersStatuses.name' => 'asc'])
            ->toArray();

        $this->set(compact('config', 'statuses', 'ordersStatuses'));
    }
}
