<?php

namespace Admin\Controller;

use Admin\Model\Entity\Menu;
use Admin\Model\Table\MenusTable;
use Admin\Model\Table\DiscountsGroupsTable;
use Admin\Model\Table\StoresTable;
use Cake\ORM\TableRegistry;

class ModulesController extends AppController
{
    /** @var StoresTable */
    public $Stores;

    public function initialize()
    {
        parent::initialize();
        $this->Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
    }

    public function index()
    {
        $modules = [
            [
                'name' => 'Lista de desejos',
                'status' => $this->Stores->getByKeyword('wish_list_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'wish-list'
            ],
            [
                'name' => 'Assinaturas',
                'status' => $this->Stores->getByKeyword('subscriptions_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'subscriptions'
            ],
            [
                'name' => 'Desconto por grupo de cliente',
                'status' => $this->Stores->getByKeyword('discount_group_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'discount-group'
            ],
            [
                'name' => 'Desconto primeira compra',
                'status' => $this->Stores->getByKeyword('discount_first_purchase_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'discount-first-purchase'
            ]
        ];

        $this->set(compact('modules'));
        $this->set('_serialize', ['modules']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function wishList()
    {
        $slug = 'wish_list';
        $result = $this->Stores->findConfig($slug);
        $entity = (object)[
            'status' => 0,
            'expiration_days' => 90
        ];
        $entity = $this->Stores->mapFindConfig($entity, $result);

        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), $slug);
            $entities = $this->Stores->newEntities($data);

            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Modulo Lista de Desejos salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'entity'));
        $this->set('_serialize', 'entity');
    }

    public function subscriptions()
    {
        $slug = 'subscriptions';
        $result = $this->Stores->findConfig($slug);
        $entity = (object)[
            'status' => 0
        ];
        $entity = $this->Stores->mapFindConfig($entity, $result);

        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), $slug);
            $entities = $this->Stores->newEntities($data);

            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Modulo Assinaturas salvas."));

                /** @var MenusTable $menuTable */
                $menuTable = TableRegistry::getTableLocator()->get('Admin.Menus');

                /** @var Menu $menu */
                $menuTable->updateAll(
                    ['status' => $this->request->getData('status')],
                    ['id IN' => [7, 8, 9]]
                );

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'entity'));
        $this->set('_serialize', 'entity');
    }

    public function discountGroup()
    {
        $slug = 'discount_group';
        $result = $this->Stores->findConfig($slug);
        $entity = (object)[
            'status' => 0,
        ];
        $entity = $this->Stores->mapFindConfig($entity, $result);

        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), $slug);
            $entities = $this->Stores->newEntities($data);

            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Modulo Grupos de Descontos salvas."));

                /** @var DiscountsGroupsTable $discountGroupTable */
                $discountGroupTable = TableRegistry::getTableLocator()->get('Admin.DiscountsGroups');
                $discountGroupTable->setMenu($this->request->getData('status'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'entity'));
        $this->set('_serialize', 'entity');
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function discountFirstPurchase()
    {
        $slug = 'discount_first_purchase';
        $result = $this->Stores->findConfig($slug);
        $entity = (object)[
            'status' => 0,
            'discount_type' => '',
            'discount' => '',
            'min' => 0,
            'max' => 0
        ];
        $entity = $this->Stores->mapFindConfig($entity, $result);

        if ($this->request->is(['post'])) {
            $data = $this->Stores->prepareSave($this->request->getData(), $slug);
            $entities = $this->Stores->newEntities($data);

            if ($this->Stores->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Desconto Primeira Compra salvas."));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $types = [
            'fixed' => 'Desconto Fixo (R$)',
            'percentage' => 'Desconto porcentagem (%)'
        ];
        $this->set(compact('statuses', 'entity', 'types'));
    }
}