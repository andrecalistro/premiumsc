<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * EmailTemplates Controller
 *
 * @property \Admin\Model\Table\EmailTemplatesTable $EmailTemplates
 *
 * @method \Admin\Model\Entity\EmailTemplate[] paginate($object = null, array $settings = [])
 */
class EmailTemplatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $emailTemplates = $this->paginate($this->EmailTemplates);

        $this->set(compact('emailTemplates'));
        $this->set('_serialize', ['emailTemplates']);
    }

    /**
     * View method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailTemplate = $this->EmailTemplates->get($id, [
            'contain' => []
        ]);

        $this->set('emailTemplate', $emailTemplate);
        $this->set('_serialize', ['emailTemplate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailTemplate = $this->EmailTemplates->newEntity();
        if ($this->request->is('post')) {
            $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->getData());
            if ($this->EmailTemplates->save($emailTemplate)) {
                $this->Flash->success(__('O template de e-mail foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O template de e-mail não pode ser salvo. Por favor, tente novamente.'));
        }

        $who_receives = ['customer' => 'Cliente', 'store' => 'Loja'];

        $this->set(compact('emailTemplate', 'who_receives'));
        $this->set('_serialize', ['emailTemplate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailTemplate = $this->EmailTemplates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->getData());
            if ($this->EmailTemplates->save($emailTemplate)) {
                $this->Flash->success(__('O template de e-mail foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O template de e-mail não pode ser salvo. Por favor, tente novamente.'));
        }

        $who_receives = ['customer' => 'Cliente', 'store' => 'Loja'];

        $this->set(compact('emailTemplate', 'who_receives'));
        $this->set('_serialize', ['emailTemplate']);
    }

	/**
	 * Edit method
	 *
	 * @param string|null $id Email Template id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function customize($id = null)
	{
		$emailTemplate = $this->EmailTemplates->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->getData());
			if ($this->EmailTemplates->save($emailTemplate)) {
				$this->Flash->success(__('O template de e-mail foi salvo.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('O template de e-mail não pode ser salvo. Por favor, tente novamente.'));
		}
		$this->set(compact('emailTemplate'));
		$this->set('_serialize', ['emailTemplate']);
	}

    /**
     * Delete method
     *
     * @param string|null $id Email Template id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailTemplate = $this->EmailTemplates->get($id);
        if ($this->EmailTemplates->delete($emailTemplate)) {
            $this->Flash->success(__('O template de e-mail foi apagado.'));
        } else {
            $this->Flash->error(__('O template de e-mail não pode ser apagado. Por favor, tente novamente'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
