<?php

namespace Admin\Controller;

use Cake\ORM\TableRegistry;

/**
 * Positions Controller
 *
 * @property \Admin\Model\Table\PositionsTable $Positions
 */
class PositionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => [
//                'PositionsPages' => function ($q) {
//                    return $q->select(['name']);
//                }
//            ]
//        ];
//        $positions = $this->paginate($this->Positions);

        $Banners = TableRegistry::getTableLocator()->get('Admin.Banners');

        $banners = $Banners->find()
            ->contain([
                'BannersImages'
            ])
            ->toArray();

        $positions = $this->Positions->find()
            ->contain([
                'PositionsPages' => function ($q) {
                    return $q->select(['name']);
                }
            ])
            ->toArray();

        $this->set(compact('positions', 'banners'));
    }

    /**
     * View method
     *
     * @param string|null $id Position id.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => [
                'PositionsPages' => function ($q) {
                    return $q->select(['name']);
                },
                'Products' => function ($q) {
                    return $q->contain(['ProductsImages'])->where(['ProductsPositions.deleted IS NULL'])->order(['ProductsPositions.order_show' => 'ASC']);
                }
            ]
        ]);

        $this->set(compact('position'));
        $this->set('_serialize', ['position']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $position = $this->Positions->newEntity();
        if ($this->request->is('post')) {
            $position = $this->Positions->patchEntity($position, $this->request->getData());
            if ($this->Positions->save($position)) {
                $this->Flash->success(__('A posição foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A posição não foi salva. Por favor, tente novamente.'));
        }
        $positions_pages = $this->Positions->PositionsPages->find('list')->orderAsc('name')->toArray();
        $this->set(compact('position', 'positions_pages'));
        $this->set('_serialize', ['position']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $position = $this->Positions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $position = $this->Positions->patchEntity($position, $this->request->getData());
            if ($this->Positions->save($position)) {
                $this->Flash->success(__('A posição foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A posição não foi salva. Por favor, tente novamente.'));
        }
        $positions_pages = $this->Positions->PositionsPages->find('list')->orderAsc('name')->toArray();
        $this->set(compact('position', 'positions_pages'));
        $this->set('_serialize', ['position']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Position id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $position = $this->Positions->get($id);
        if ($this->Positions->delete($position)) {
            $this->Flash->success(__('A posição foi excluída.'));
        } else {
            $this->Flash->error(__('A posição não foi excluida. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $positions_id
     * @return \Cake\Http\Response|null
     */
    public function addProduct($positions_id)
    {
        $position = $this->Positions->get($positions_id);
        $product_position = $this->Positions->ProductsPositions->newEntity();

        if (!$position) {
            return $this->redirect(['controller' => 'positions', 'action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $product_position = $this->Positions->ProductsPositions->patchEntity($product_position, $this->request->getData());
            if ($this->Positions->ProductsPositions->save($product_position)) {
                $this->Flash->success(__('Produto adicionado.'));
                return $this->redirect(['controller' => 'positions', 'action' => 'view', $positions_id]);
            }
            $this->Flash->error(__('Produto não foi adicionado. Por favor, tente novamente.'));
        }

        $products = $this->Positions->Products->find()
            ->contain('ProductsImages')
			->where(['Products.status' => 1])
            ->order(['Products.name' => 'ASC'])
            ->toArray();

        $this->set(compact('position', 'product_position', 'products'));
    }

    /**
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function deleteProduct($id)
    {
        $product = $this->Positions->ProductsPositions->get($id);

        if (!$product) {
            return $this->redirect(['controller' => 'positions', 'action' => 'index']);
        }

        if ($this->request->is(['post'])) {
            if ($this->Positions->ProductsPositions->hardDelete($product)) {
                $this->Flash->success(__("Produto excluído."));
            } else {
                $this->Flash->error(__("Produto não foi excluído. Por favor, tente novamente."));
            }
        }
        return $this->redirect(['controller' => 'positions', 'action' => 'view', $product->positions_id]);
    }

    /**
     *
     */
    public function changePosition()
    {
        $json = [
            'status' => true,
            'message' => ''
        ];

        if ($this->request->is('post')) {
            if ($this->request->getData('id') && ($this->request->getData('order_show') || $this->request->getData('order_show') == 0)) {
                $product_position = $this->Positions->ProductsPositions->get($this->request->getData('id'));
                $product_position->order_show = $this->request->getData('order_show');
                if ($this->Positions->ProductsPositions->save($product_position)) {
                    $json['message'] = 'Posição alterada com sucesso.';
                } else {
                    $json['status'] = false;
                    $json['message'] = 'Ocorreu um erro ao alterar a posição do produto. Por favor, tente novamente.';
                }
            } else {
                $json['status'] = false;
                $json['message'] = 'É obrigatório enviar id e position.';
            }
        } else {
            $json['status'] = false;
            $json['message'] = 'Método permitido somente POST';
        }

        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }
}
