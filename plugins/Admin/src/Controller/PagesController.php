<?php

namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Pages Controller
 *
 * @property \Admin\Model\Table\PagesTable $Pages
 *
 * @method \Admin\Model\Entity\Page[] paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $pages = $this->paginate($this->Pages);

        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);

        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $page = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('A página foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A página não foi salva. Por favor, tente novamente.'));
        }
        $statuses = [0 => __('Não publicada'), 1 => __('Publicada')];
        $this->set(compact('page', 'statuses'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->getData());
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('A página foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A página não foi salva. Por favor, tente novamente.'));
        }
        $statuses = [0 => __('Não publicada'), 1 => __('Publicada')];
        $this->set(compact('page', 'statuses'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Page id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('A página foi excluída.'));
        } else {
            $this->Flash->error(__('A página não foi excluída. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
