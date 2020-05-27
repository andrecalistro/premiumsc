<?php

namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\View\CellTrait;

/**
 * VariationsGroups Controller
 *
 * @property \Admin\Model\Table\VariationsGroupsTable $VariationsGroups
 *
 * @method \Admin\Model\Entity\VariationsGroup[] paginate($object = null, array $settings = [])
 */
class VariationsGroupsController extends AppController
{
    use CellTrait;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $variationsGroups = $this->paginate($this->VariationsGroups);

        $this->set(compact('variationsGroups'));
        $this->set('_serialize', ['variationsGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Variations Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $variationsGroup = $this->VariationsGroups->get($id, [
            'contain' => ['Variations']
        ]);

        $this->set('variationsGroup', $variationsGroup);
        $this->set('_serialize', ['variationsGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $variationsGroup = $this->VariationsGroups->newEntity();
        if ($this->request->is('post')) {
            $variationsGroup = $this->VariationsGroups->patchEntity($variationsGroup, $this->request->getData(), ['associated' => ['Variations']]);
            if ($this->VariationsGroups->save($variationsGroup)) {
                $this->Flash->success(__('O Grupo de variações salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O Grupo de variações não foi salvo. Por favor, tente novamente.'));
        }
        $auxiliary_field_types = ['text' => 'Texto', 'image' => 'Upload de imagem'];
        $this->set(compact('variationsGroup', 'auxiliary_field_types'));
        $this->set('_serialize', ['variationsGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Variations Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $variationsGroup = $this->VariationsGroups->get($id, [
            'contain' => ['Variations']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $variationsGroup = $this->VariationsGroups->patchEntity($variationsGroup, $this->request->getData(), ['associated' => ['Variations']]);
            if ($this->VariationsGroups->save($variationsGroup)) {
                $this->Flash->success(__('O Grupo de variações salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O Grupo de variações não foi salvo. Por favor, tente novamente.'));
        }
        $auxiliary_field_types = ['text' => 'Texto', 'image' => 'Upload de imagem'];
        $this->set(compact('variationsGroup', 'auxiliary_field_types'));
        $this->set('_serialize', ['variationsGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Variations Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $variationsGroup = $this->VariationsGroups->get($id);
        if ($this->VariationsGroups->delete($variationsGroup)) {
            $this->Flash->success(__('O Grupo de variações foi excluído.'));
        } else {
            $this->Flash->error(__('O Grupo de variações não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $variations_id
     * @return \Cake\Http\Response|null
     */
    public function deleteVariation($variations_id)
    {
        $response = [];
        $this->request->allowMethod(['post', 'delete']);
        $variation = $this->VariationsGroups->Variations->get($variations_id);
        if ($this->VariationsGroups->Variations->delete($variation)) {
            if (!$this->request->is('ajax')) {
                $this->Flash->success(__('Variação foi excluída.'));
                return $this->redirect($this->referer());
            }
            $response['status'] = true;
        } else {
            if (!$this->request->is('ajax')) {
                $this->Flash->error(__('Variação não foi excluído. Por favor, tente novamente.'));
                return $this->redirect($this->referer());
            }
            $response['status'] = false;
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    /**
     *
     */
    public function getContent()
    {
        $json = [
            'status' => false,
            'content' => ''
        ];

        $variations_group = $this->VariationsGroups->get($this->request->getData('variations_groups_id'));

        if ($variations_group) {
            $json['status'] = true;
            $json['content'] = $this->cell('Admin.VariationGroup::display', [$variations_group])->render();
        }

        $this->set(compact('json'));
    }

    /**
     *
     */
    public function newVariationContent()
    {
        $json = [
            'status' => false,
            'content' => ''
        ];

        $variations_group = $this->VariationsGroups->get($this->request->getData('variations_groups_id'), [
            'contain' => [
                'Variations' => function ($q) {
                    return $q->order('Variations.name');
                }
            ]
        ]);

        if ($variations_group) {
            $json['status'] = true;
            $json['content'] = $this->cell('Admin.VariationGroup::newVariation', [$variations_group])->render();
        }

        $this->set(compact('json'));
    }
}
