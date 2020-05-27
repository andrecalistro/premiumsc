<?php
namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * PaymentsMethods Controller
 *
 * @property \Admin\Model\Table\PaymentsMethodsTable $PaymentsMethods
 *
 * @method \Admin\Model\Entity\PaymentsMethod[] paginate($object = null, array $settings = [])
 */
class PaymentsMethodsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $paymentsMethods = $this->paginate($this->PaymentsMethods);

        $this->set(compact('paymentsMethods'));
        $this->set('_serialize', ['paymentsMethods']);
    }

    /**
     * View method
     *
     * @param string|null $id Payments Method id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentsMethod = $this->PaymentsMethods->get($id, [
            'contain' => []
        ]);

        $this->set('paymentsMethod', $paymentsMethod);
        $this->set('_serialize', ['paymentsMethod']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentsMethod = $this->PaymentsMethods->newEntity();
        if ($this->request->is('post')) {
            $paymentsMethod = $this->PaymentsMethods->patchEntity($paymentsMethod, $this->request->getData());
            if ($this->PaymentsMethods->save($paymentsMethod)) {
                $this->Flash->success(__('O metodo de pagamento foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O metodo de pagamento não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('paymentsMethod'));
        $this->set('_serialize', ['paymentsMethod']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Payments Method id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentsMethod = $this->PaymentsMethods->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentsMethod = $this->PaymentsMethods->patchEntity($paymentsMethod, $this->request->getData());
            if ($this->PaymentsMethods->save($paymentsMethod)) {
                $this->Flash->success(__('O metodo de pagamento foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O metodo de pagamento não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('paymentsMethod'));
        $this->set('_serialize', ['paymentsMethod']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payments Method id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentsMethod = $this->PaymentsMethods->get($id);
        if ($this->PaymentsMethods->delete($paymentsMethod)) {
            $this->Flash->success(__('O metodo de pagamento foi excluído.'));
        } else {
            $this->Flash->error(__('O metodo de pagamento não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
