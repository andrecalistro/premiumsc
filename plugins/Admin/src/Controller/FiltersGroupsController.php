<?php

namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * FiltersGroups Controller
 *
 * @property \Admin\Model\Table\FiltersGroupsTable $FiltersGroups
 *
 * @method \Admin\Model\Entity\FiltersGroup[] paginate($object = null, array $settings = [])
 */
class FiltersGroupsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $filtersGroups = $this->paginate($this->FiltersGroups);

        $this->set(compact('filtersGroups'));
        $this->set('_serialize', ['filtersGroups']);
    }

    /**
     * View method
     *
     * @param string|null $id Filters Group id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $filtersGroup = $this->FiltersGroups->get($id, [
            'contain' => ['Filters']
        ]);

        $this->set('filtersGroup', $filtersGroup);
        $this->set('_serialize', ['filtersGroup']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $filtersGroup = $this->FiltersGroups->newEntity();
        if ($this->request->is('post')) {
            $filtersGroup = $this->FiltersGroups->patchEntity($filtersGroup, $this->request->getData(), ['associated' => ['Filters']]);
            if ($this->FiltersGroups->save($filtersGroup)) {
                $this->Flash->success(__('Os filtros foram salvos.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Os filtros não foram salvos. Por favor, tente novamente.'));
        }
        $this->set(compact('filtersGroup'));
        $this->set('_serialize', ['filtersGroup']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Filters Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $filtersGroup = $this->FiltersGroups->get($id, [
            'contain' => ['Filters']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $filtersGroup = $this->FiltersGroups->patchEntity($filtersGroup, $this->request->getData(), ['associated' => ['Filters']]);
            if ($this->FiltersGroups->save($filtersGroup)) {
                $this->Flash->success(__('OS filtros foram salvos.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Os filtros não foram salvos. Por favor, tente novamente.'));
        }
        $this->set(compact('filtersGroup'));
        $this->set('_serialize', ['filtersGroup']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Filters Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $filtersGroup = $this->FiltersGroups->get($id);
        if ($this->FiltersGroups->delete($filtersGroup)) {
            $this->Flash->success(__('Os filtros foram excluídos.'));
        } else {
            $this->Flash->error(__('Os filtros não foram excluídos. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * used in add and edit filters groups
     *
     * @param $filters_id
     * @return \Cake\Http\Response|null
     */
    public function deleteFilter($filters_id)
    {
        $response = [];
        $this->request->allowMethod(['post', 'delete']);
        $filtersGroup = $this->FiltersGroups->Filters->get($filters_id);
        if ($this->FiltersGroups->Filters->delete($filtersGroup)) {
            if (!$this->request->is('ajax')) {
                $this->Flash->success(__('Filtro foi excluído.'));
                return $this->redirect($this->referer());
            }
            $response['status'] = true;
        } else {
            if (!$this->request->is('ajax')) {
                $this->Flash->error(__('Filtro não foi excluído. Por favor, tente novamente.'));
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
    public function items()
    {
        $conditions = [];
        if ($this->request->getQuery('q')) {
            $conditions = [
                'OR' => [
                    'Filters.name LIKE' => '%' . $this->request->getQuery('q') . '%',
                    'FiltersGroups.name LIKE' => '%' . $this->request->getQuery('q') . '%'
                ]
            ];
        }

        $items = $this->FiltersGroups->Filters->items($conditions);

        $this->set(compact('items'));
        $this->set('_serialize', ['items']);
    }

    /**
     * @param null $filters_groups_id
     * @return \Cake\Http\Response|null
     */
    public function addFilter($filters_groups_id = null)
    {
        if (!$filters_groups_id) {
            return $this->redirect(['controller' => 'filters-groups', 'action' => 'index']);
        }

        $filter = $this->FiltersGroups->Filters->newEntity();

        if ($this->request->is(['post', 'put'])) {
            $filter = $this->FiltersGroups->Filters->patchEntity($filter, $this->request->getData());
            if ($this->FiltersGroups->Filters->save($filter)) {
                $this->Flash->success(__('Filtro foi salvo.'));
                return $this->redirect(['controller' => 'filters-groups', 'action' => 'view', $filter->filters_groups_id]);
            }
            $this->Flash->error(__('Filtro não foi salvo. Por favor tente novamente.'));
        }

        $this->set(compact('filter', 'filters_groups_id'));
        $this->set('_serialize', ['filter']);
    }

    /**
     * @param $filters_id
     * @return \Cake\Http\Response|null
     */
    public function editFilter($filters_id)
    {
        $filter = $this->FiltersGroups->Filters->get($filters_id);

        if (!$filter) {
            return $this->redirect(['controller' => 'filters-groups', 'action' => 'index']);
        }

        if ($this->request->is(['post', 'put'])) {
            $filter = $this->FiltersGroups->Filters->patchEntity($filter, $this->request->getData());
            if ($this->FiltersGroups->Filters->save($filter)) {
                $this->Flash->success(__('Filtro foi salvo.'));
                return $this->redirect(['controller' => 'filters-groups', 'action' => 'view', $filter->filters_groups_id]);
            }
            $this->Flash->error(__('Filtro não foi salvo. Por favor tente novamente.'));
        }

        $this->set(compact('filter'));
        $this->set('_serialize', ['filter']);
    }
}
