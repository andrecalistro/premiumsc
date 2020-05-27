<?php

namespace Admin\Controller;

use Cake\ORM\TableRegistry;

/**
 * PaymentsTicketsReturns Controller
 *
 * @property \Admin\Model\Table\PaymentsTicketsReturnsTable $PaymentsTicketsReturns
 *
 * @method \Admin\Model\Entity\PaymentsTicketsReturn[] paginate($object = null, array $settings = [])
 */
class PaymentsTicketsReturnsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'order' => [
                'PaymentsTicketsReturns.id' => 'desc'
            ]
        ];
        $paymentsTicketsReturns = $this->paginate($this->PaymentsTicketsReturns);

        $this->set(compact('paymentsTicketsReturns'));
        $this->set('_serialize', ['paymentsTicketsReturns']);
    }

    /**
     * View method
     *
     * @param string|null $id Payments Tickets Return id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentsTicketsReturn = $this->PaymentsTicketsReturns->get($id, [
            'contain' => []
        ]);

        $this->set('paymentsTicketsReturn', $paymentsTicketsReturn);
        $this->set('_serialize', ['paymentsTicketsReturn']);
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function add()
    {
        if ($this->request->getData('file.error') == 0) {
            $PaymentsTickets = TableRegistry::getTableLocator()->get('Admin.PaymentsTickets');
            $paymentsTicketsReturn = $this->PaymentsTicketsReturns->newEntity();
            $fileReturns = new \Eduardokum\LaravelBoleto\Cnab\Retorno\Cnab400\Banco\Bradesco($this->request->getData('file.tmp_name'));
            $fileReturns->processar();
            foreach ($fileReturns->getDetalhes() as $fileReturn) {
                $ticket = $PaymentsTickets->find()
                    ->where([
                        'ticket_code' => $fileReturn->nossoNumero
                    ])
                    ->contain([
                        'Orders'
                    ])
                    ->first();

                if ($ticket) {
                    $paymentsTicketsReturn->quantity_tickets++;
                    if (!$ticket->payment_tickets_returns_id) {
                        $ticket->amount_paid = $fileReturn->valorRecebido;
                        $ticket->payment_date = $fileReturn->dataCredito;
                        $PaymentsTickets->save($ticket);
                        if($ticket->order->orders_statuses_id == 1) {
                            $PaymentsTickets->Orders->addHistory($ticket->orders_id, 2, 'Seu pagamento foi aprovado', true);
                        }
                    }
                }
            }
            $paymentsTicketsReturn->file_name = $this->request->getData('file.name');
            $paymentsTicketsReturn = $this->PaymentsTicketsReturns->patchEntity($paymentsTicketsReturn, $this->request->getData());
            if ($this->PaymentsTicketsReturns->save($paymentsTicketsReturn)) {
                $this->Flash->success(__('Arquivo de retorno processado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Ocorreu um erro ao processar o arquivo de retorno, por favor, tente novamente'));
                return $this->redirect(['controller' => 'payments-tickets-returns', 'action' => 'index']);
            }
        } else {
            $this->Flash->error(__('Ocorreu um erro ao processar o arquivo de retorno, por favor, tente novamente'));
            return $this->redirect(['controller' => 'payments-tickets-returns', 'action' => 'index']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Payments Tickets Return id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentsTicketsReturn = $this->PaymentsTicketsReturns->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentsTicketsReturn = $this->PaymentsTicketsReturns->patchEntity($paymentsTicketsReturn, $this->request->getData());
            if ($this->PaymentsTicketsReturns->save($paymentsTicketsReturn)) {
                $this->Flash->success(__('The payments tickets return has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payments tickets return could not be saved. Please, try again.'));
        }
        $this->set(compact('paymentsTicketsReturn'));
        $this->set('_serialize', ['paymentsTicketsReturn']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Payments Tickets Return id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentsTicketsReturn = $this->PaymentsTicketsReturns->get($id);
        if ($this->PaymentsTicketsReturns->delete($paymentsTicketsReturn)) {
            $this->Flash->success(__('The payments tickets return has been deleted.'));
        } else {
            $this->Flash->error(__('The payments tickets return could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
