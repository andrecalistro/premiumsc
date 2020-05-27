<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * Rules Controller
 *
 * @property \Admin\Model\Table\RulesTable $Rules
 *
 * @method \Admin\Model\Entity\Rule[] paginate($object = null, array $settings = [])
 */
class RulesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $rules = $this->paginate($this->Rules);

        $this->set(compact('rules'));
        $this->set('_serialize', ['rules']);
    }

    /**
     * View method
     *
     * @param string|null $id Rule id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rule = $this->Rules->get($id, [
            'contain' => ['Menus']
        ]);

        $this->set('rule', $rule);
        $this->set('_serialize', ['rule']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rule = $this->Rules->newEntity();
        if ($this->request->is('post')) {
            $rule = $this->Rules->patchEntity($rule, $this->request->getData());
            if ($this->Rules->save($rule)) {
                $this->Flash->success(__('O grupo foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O grupo não pode ser salvo. Por favor, tente novamente.'));
        }
        $menus = $this->Rules->Menus->find('list', ['limit' => 200])->order(['Menus.name' => 'ASC']);
		$public = [1 => 'Sim', 0 => 'Não'];
        $this->set(compact('rule', 'menus', 'public'));
        $this->set('_serialize', ['rule']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rule id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rule = $this->Rules->get($id, [
            'contain' => ['Menus']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rule = $this->Rules->patchEntity($rule, $this->request->getData());
            if ($this->Rules->save($rule)) {
				$this->Flash->success(__('O grupo foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
			$this->Flash->error(__('O grupo não pode ser salvo. Por favor, tente novamente.'));
        }
        $menus = $this->Rules->Menus->find('list', ['limit' => 200])->order(['Menus.name' => 'ASC']);
		$public = [1 => 'Sim', 0 => 'Não'];
        $this->set(compact('rule', 'menus', 'public'));
        $this->set('_serialize', ['rule']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rule id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rule = $this->Rules->get($id);
        if ($this->Rules->delete($rule)) {
			$this->Flash->success(__('O grupo foi apagado.'));
        } else {
			$this->Flash->error(__('O grupo não pode ser apagado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
