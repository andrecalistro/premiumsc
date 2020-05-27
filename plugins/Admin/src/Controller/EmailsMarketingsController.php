<?php

namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\I18n\Date;

/**
 * EmailsMarketings Controller
 *
 * @property \Admin\Model\Table\EmailsMarketingsTable $EmailsMarketings
 *
 * @method \Admin\Model\Entity\EmailsMarketing[] paginate($object = null, array $settings = [])
 */
class EmailsMarketingsController extends AppController
{

    public $import_fields;

    public function initialize()
    {
        parent::initialize();
        $this->import_fields = [
            'null' => 'Não usar',
            'name' => 'Nome',
            'email' => 'E-mail'
        ];
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers']
        ];
        $emailsMarketings = $this->paginate($this->EmailsMarketings);

        $total = $this->request->getParam('paging')['EmailsMarketings']['count'];

        if ($total == 0) {
            $messageTotalEmails = __("NENHUM E-MAIL ENCONTRADO");
        } else {
            $messageTotalEmails = sprintf(__n("%s E-MAIL NA BASE DE DADOS", "%s E-MAILS NA BASE DE DADOS", $total), $total);
        }

        $this->set(compact('emailsMarketings', 'messageTotalEmails'));
        $this->set('_serialize', ['emailsMarketings']);
    }

    /**
     * View method
     *
     * @param string|null $id Emails Marketing id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $emailsMarketing = $this->EmailsMarketings->get($id, [
            'contain' => ['Customers']
        ]);

        $this->set('emailsMarketing', $emailsMarketing);
        $this->set('_serialize', ['emailsMarketing']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $emailsMarketing = $this->EmailsMarketings->newEntity();
        if ($this->request->is('post')) {
            $emailsMarketing = $this->EmailsMarketings->patchEntity($emailsMarketing, $this->request->getData());
            if ($this->EmailsMarketings->save($emailsMarketing)) {
                $this->Flash->success(__('The emails marketing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emails marketing could not be saved. Please, try again.'));
        }
        $customers = $this->EmailsMarketings->Customers->find('list', ['limit' => 200]);
        $this->set(compact('emailsMarketing', 'customers'));
        $this->set('_serialize', ['emailsMarketing']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Emails Marketing id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $emailsMarketing = $this->EmailsMarketings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $emailsMarketing = $this->EmailsMarketings->patchEntity($emailsMarketing, $this->request->getData());
            if ($this->EmailsMarketings->save($emailsMarketing)) {
                $this->Flash->success(__('The emails marketing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The emails marketing could not be saved. Please, try again.'));
        }
        $customers = $this->EmailsMarketings->Customers->find('list', ['limit' => 200]);
        $this->set(compact('emailsMarketing', 'customers'));
        $this->set('_serialize', ['emailsMarketing']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Emails Marketing id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $emailsMarketing = $this->EmailsMarketings->get($id);
        if ($this->EmailsMarketings->delete($emailsMarketing)) {
            $this->Flash->success(__('The emails marketing has been deleted.'));
        } else {
            $this->Flash->error(__('The emails marketing could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function export()
    {
        $this->autoRender = false;

        $emailsMarketings = $this->EmailsMarketings->find('all')
            ->where(['status' => 1])
            ->toArray();

        if (!$emailsMarketings) {
            $this->Flash->error(__("Sem registros para exportar"));
            return $this->redirect(['controller' => 'emails-marketings', 'action' => 'index']);
        }

        $delimiter = ";";
        $filename = 'emails-' . Date::now()->format("d-m-Y") . '.csv';

        $f = fopen('php://memory', 'w');

        $fields = ['Nome', 'E-mail', 'Cadastrado em'];
        fputcsv($f, $fields, $delimiter);

        foreach ($emailsMarketings as $emailsMarketing) {
            $lineData = [
                $emailsMarketing->name,
                $emailsMarketing->email,
                $emailsMarketing->created->format('d/m/Y')
            ];
            fputcsv($f, $lineData, $delimiter);
        }

        fseek($f, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
    }


    /**
     * @return \Cake\Http\Response|null
     */
    public function import()
    {
        $file = '';
        $this->request->getSession()->delete('import_email_csv_file');
        $this->request->getSession()->delete('import_email_csv_header');

        if ($this->request->is('post')) {
            $file = $this->request->getData('file');

            if (!$file) {
                $this->Flash->error(__('Selecione um arquivo para enviar'));
                return $this->redirect(['controller' => 'products', 'action' => 'import']);
            }

            if ($file['error'] > 0) {
                $this->Flash->error(__('Houve um erro ao enviar seu arquivo, tente novamente'));
                return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import']);
            }

            $file = $this->request->getData('file');
            $data = str_getcsv(file_get_contents($file['tmp_name']), "\n");
            if (!$data) {
                $this->Flash->error(__('O arquivo CSV enviado está vazio. Por favor, selecione outro arquivo e tente novamente.'));
                return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import']);
            }

            $header = explode(";", $data[0]);
            $file_name = WWW_ROOT . 'csv' . DS . 'importacao_emails_csv_' . Date::now('America/Sao_Paulo')->getTimestamp() . '.csv';
            if (!is_dir(WWW_ROOT . 'csv')) {
                mkdir(WWW_ROOT . 'csv');
            }

            $this->removeAllCsvs();

            if (!move_uploaded_file($file['tmp_name'], $file_name)) {
                $this->Flash->error(__('Não foi possivel salvar seu arquivo temporariamente. Por favor, tente novamente.'));
                return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import']);
            }

            $this->request->getSession()->write('import_email_csv_file', $file_name);
            $this->request->getSession()->write('import_email_csv_header', $header);
            return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import-map-columns']);
        }

        $this->set(compact('file'));
        $this->set('_serialize', ['file']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function importMapColumns()
    {
        if (!$this->request->getSession()->check('import_email_csv_header') || !$this->request->getSession()->check('import_email_csv_file')) {
            $this->Flash->error(__("É preciso enviar um arquivo CSV antes de mapear as colunas"));
            return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import']);
        }

        if ($this->request->is(['post', 'put'])) {
            $maps = $this->request->getData('map');
            $data = str_getcsv(file_get_contents($this->request->getSession()->read('import_email_csv_file')), PHP_EOL);
            $fields = [];
            $emails_added = $emails_updated = 0;
            unset($data[0]);

            if (!in_array('email', $maps)) {
                $this->Flash->error(__('Você deve selecionar o campo E-mail em alguma coluna para identificação do produto no sistema'));
                return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import-map-columns']);
            }

            foreach ($data as $line_csv) {
                $item = explode(';', $line_csv);
                foreach ($maps as $key => $map) {
                    if ($map != 'null') {
                        $fields[$map] = $item[trim($key)];
                    }
                }

                $new = false;

                $emailsMarketing = $this->EmailsMarketings->find()
                    ->where(['email' => trim($fields['email'])])
                    ->first();

                if (!$emailsMarketing) {
                    $new = true;
                    $emailsMarketing = $this->EmailsMarketings->newEntity();
                }

                $emailsMarketing->origin = 1;
                foreach ($fields as $key => $value) {
                    if (!empty(trim($value))) {
                        $emailsMarketing->$key = trim($value);
                    }
                }

                if ($this->EmailsMarketings->save($emailsMarketing)) {
                    if ($new) {
                        $emails_added++;
                    } else {
                        $emails_updated++;
                    }
                }
            }

            $message = "E-mails adicionados: $emails_added<br>";
            $message .= "E-mails atualizados: $emails_updated<br>";

            $this->Flash->success($message);
            return $this->redirect(['controller' => 'emails-marketings', 'action' => 'import']);
        }

        $columns = $this->request->getSession()->read('import_email_csv_header');
        $fields = $this->import_fields;

        $this->set(compact('columns', 'fields'));
        $this->set('_serialize', ['columns', 'fields']);
    }

    protected function removeAllCsvs()
    {
        $folder = WWW_ROOT . 'csv';

        if (is_dir($folder)) {
            $files = scandir($folder);
            if ($files) {
                foreach ($files as $file) {
                    if (!in_array($file, ['.', '..'])) {
                        unlink($folder . DS . $file);
                    }
                }
            }
        }
    }
}
