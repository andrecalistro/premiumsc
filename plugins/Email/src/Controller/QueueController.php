<?php

namespace Email\Controller;

use Admin\Model\Table\EmailQueuesTable;
use Admin\Model\Table\StoresTable;
use Cake\Core\Exception\Exception;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;

/**
 * Class QueueController
 * @package Email\Controller
 *
 * @property StoresTable $Stores
 * @property EmailQueuesTable $EmailQueues
 */
class QueueController extends AppController
{
    public $Stores;
    public $EmailQueues;
    public $store_config;

    public function initialize()
    {
        parent::initialize();
        $this->Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $this->EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');
        $this->store_config = $this->Stores->findConfig('garrula');
    }

    /**
     * @param null $token
     * @throws \Exception
     */
    public function send($token = null)
    {
        if (!$token || $token != $this->store_config->api_token) {
            throw new \Exception(__('Token inválido. Você não tem permissão para acessar esse metódo.'));
        }

        $json = [
            'status' => true,
            'message' => ''
        ];

        $EmailQueues = TableRegistry::getTableLocator()->get('Admin.EmailQueues');
        $queues = $EmailQueues->find()
            ->where([
                'EmailQueues.email_statuses_id' => 1
            ])
            ->limit(10)
            ->toArray();

        if ($queues) {
            $count_emails = 0;
            $mail = new Email();
            foreach ($queues as $queue) {
                if(empty($queue->from_email) || empty($queue->from_name)){
                    $queue = $this->EmailQueues->patchEntity($queue, ['email_statuses_id' => 3, 'send_status' => 'Faltando remetente']);
                    $this->EmailQueues->save($queue);
                    continue;
                }

                if(empty($queue->to_email) || empty($queue->to_name)){
                    $queue = $this->EmailQueues->patchEntity($queue, ['email_statuses_id' => 3, 'send_status' => 'Faltando destinatario']);
                    $this->EmailQueues->save($queue);
                    continue;
                }

                try {
                    $mail->setTransport('nerdweb')
                        ->setEmailFormat('html')
                        ->setTemplate('Email.default')
                        ->setFrom($queue->from_email, $queue->from_name)
                        ->setTo($queue->to_email, $queue->to_name)
                        ->setSubject(__($queue->subject))
                        ->setViewVars([
                            'content' => $queue->content
                        ]);

                    if (!empty($queue->reply_name) && !empty($queue->reply_email)) {
                        $mail->setReplyTo($queue->reply_email, $queue->name);
                    }

                    $mail->send();

                    $queue = $this->EmailQueues->patchEntity($queue, ['email_statuses_id' => 2, 'send_status' => 'Enviado']);
                    $count_emails++;
                    $this->EmailQueues->save($queue);
                } catch (Exception $e) {
                    $queue = $this->EmailQueues->patchEntity($queue, ['email_statuses_id' => 3, 'send_status' => $e->getMessage()]);
                    $this->EmailQueues->save($queue);
                }

            }
            $json['status'] = true;
            $json['message'] = sprintf('Foram enviados %s e-mails.', $count_emails);
        } else {
            $json['message'] = 'Nenhum e-mail para ser enviado.';
            $json['status'] = false;
        }

        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }
}