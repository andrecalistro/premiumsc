<?php

namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * FaqCategories Controller
 *
 * @property \Admin\Model\Table\FaqCategoriesTable $FaqCategories
 *
 * @method \Admin\Model\Entity\FaqCategory[] paginate($object = null, array $settings = [])
 */
class FaqCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $faqCategories = $this->paginate($this->FaqCategories);

        $this->set(compact('faqCategories'));
        $this->set('_serialize', ['faqCategories']);
    }

    /**
     * View method
     *
     * @param string|null $id Faq Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $faqCategory = $this->FaqCategories->get($id, [
            'contain' => []
        ]);

        $this->set('faqCategory', $faqCategory);
        $this->set('_serialize', ['faqCategory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $faqCategory = $this->FaqCategories->newEntity();
        if ($this->request->is('post')) {
            $faqCategory = $this->FaqCategories->patchEntity($faqCategory, $this->request->getData());
            if ($this->FaqCategories->save($faqCategory)) {
                $this->Flash->success(__('A categoria foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A categoria não foi salva. Por favor, tente novamente.'));
        }
        $this->set(compact('faqCategory'));
        $this->set('_serialize', ['faqCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $faqCategory = $this->FaqCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faqCategory = $this->FaqCategories->patchEntity($faqCategory, $this->request->getData());
            if ($this->FaqCategories->save($faqCategory)) {
                $this->Flash->success(__('A categoria foi salva.'));

                return $this->redirect(['action' => 'index']);
            }
			$this->Flash->error(__('A categoria não foi salva. Por favor, tente novamente.'));
        }
        $this->set(compact('faqCategory'));
        $this->set('_serialize', ['faqCategory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Faq Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $faqCategory = $this->FaqCategories->get($id);
        if ($this->FaqCategories->delete($faqCategory)) {
            $this->Flash->success(__('A categoria foi excluída.'));
        } else {
			$this->Flash->error(__('A categoria não foi excluída. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
