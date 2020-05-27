<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * FaqQuestions Controller
 *
 * @property \Admin\Model\Table\FaqQuestionsTable $FaqQuestions
 *
 * @method \Admin\Model\Entity\FaqQuestion[] paginate($object = null, array $settings = [])
 */
class FaqQuestionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
//        $this->paginate = [
//            'contain' => ['FaqCategories']
//        ];
//        $faqQuestions = $this->paginate($this->FaqQuestions);
//
//        $this->set(compact('faqQuestions'));
//        $this->set('_serialize', ['faqQuestions']);
    }

	public function category($faqCategoryId)
	{
		$this->paginate = [
			'conditions' => ['FaqQuestions.faq_categories_id' => $faqCategoryId],
			'contain' => ['FaqCategories']
		];

		$faqCategory = $this->FaqQuestions->FaqCategories->get($faqCategoryId);
		$faqQuestions = $this->paginate($this->FaqQuestions);

		$this->set(compact('faqCategory', 'faqQuestions'));
		$this->set('_serialize', ['faqCategory', 'faqQuestions']);
	}

    /**
     * View method
     *
     * @param string|null $id Faq Question id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $faqQuestion = $this->FaqQuestions->get($id, [
            'contain' => ['FaqCategories']
        ]);

        $this->set('faqQuestion', $faqQuestion);
        $this->set('_serialize', ['faqQuestion']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($faqCategoryId)
    {
        $faqQuestion = $this->FaqQuestions->newEntity();
        if ($this->request->is('post')) {
            $faqQuestion = $this->FaqQuestions->patchEntity($faqQuestion, $this->request->getData());
            if ($this->FaqQuestions->save($faqQuestion)) {
                $this->Flash->success(__('O registro foi salvo!'));

                return $this->redirect(['action' => 'category', $faqQuestion->faq_categories_id]);
            }
            $this->Flash->error(__('O registro não foi salvo. Por favor, tente novamente.'));
        }
        $faqCategories = $this->FaqQuestions->FaqCategories->find('list', ['limit' => 200]);
        $this->set(compact('faqQuestion', 'faqCategories', 'faqCategoryId'));
        $this->set('_serialize', ['faqQuestion']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Faq Question id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $faqQuestion = $this->FaqQuestions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $faqQuestion = $this->FaqQuestions->patchEntity($faqQuestion, $this->request->getData());
            if ($this->FaqQuestions->save($faqQuestion)) {
				$this->Flash->success(__('O registro foi salvo!'));

				return $this->redirect(['action' => 'category', $faqQuestion->faq_categories_id]);
            }
			$this->Flash->error(__('O registro não foi salvo. Por favor, tente novamente.'));
        }
        $faqCategories = $this->FaqQuestions->FaqCategories->find('list', ['limit' => 200]);
        $this->set(compact('faqQuestion', 'faqCategories'));
        $this->set('_serialize', ['faqQuestion']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Faq Question id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $faqQuestion = $this->FaqQuestions->get($id);
        if ($this->FaqQuestions->delete($faqQuestion)) {
			$this->Flash->success(__('O registro foi apagado!'));
			return $this->redirect(['action' => 'category', $faqQuestion->faq_categories_id]);
        } else {
			$this->Flash->error(__('O registro não foi apagado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
