<?php

namespace Admin\Controller;

use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \Admin\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rules']
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Rules']
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O usuário não foi salvo. Por favor, tente novamente.'));
        }

        if ($this->Auth->user('rules_id') == 2) {
            $rules = $this->Users->Rules->find('list', ['limit' => 200]);
        } else {
            $rules = $this->Users->Rules->find('list', ['conditions' => ['public' => 1], 'limit' => 200]);
        }

        $this->set(compact('user', 'rules'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        unset($user->password);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->Users->getValidator()->remove('password', 'sameAs');
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if (!$user->password) {
                unset($user->password);
            }
            if ($this->Users->save($user)) {
                $this->Flash->success(__('O usuário foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O usuário não foi salvo. Por favor, tente novamente.'));
        }

        if ($this->Auth->user('rules_id') == 2) {
            $rules = $this->Users->Rules->find('list', ['limit' => 200]);
        } else {
            $rules = $this->Users->Rules->find('list', ['conditions' => ['public' => 1], 'limit' => 200]);
        }

        $this->set(compact('user', 'rules'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        if ($id == $this->request->getSession()->read('Auth.User.id')) {
            $this->Flash->error(__("Você não pode excluir o seu usuário."));
            return $this->redirect(['action' => 'index']);
        }

        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('O usuário foi excluído.'));
        } else {
            $this->Flash->error(__('O usuário não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     *
     */
    public function login()
    {
        $this->viewBuilder()->setLayout('login');

        if ($this->request->getSession()->check('Auth.User.id') && in_array($this->Auth->user('rules_id'), [1, 2])) {
            return $this->redirect($this->Auth->redirectUrl());
        }

        if ($this->request->is(['post'])) {
            $user = $this->Auth->identify();

            if ($user && $user['deleted'] == null) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('E-mail ou senha inválido. Por favor, tente novamente'));
            }
        }
    }

    /**
     *
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function passwordChange()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__("Sua senha foi alterada."));
            } else {
                $this->Flash->error(__("Sua senha não foi alterada. Por favor, tente novamente."));
            }
            return $this->redirect(['controller' => 'users', 'action' => 'password-change']);
        }
        unset($user->password);
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
}
