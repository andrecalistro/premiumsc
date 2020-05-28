<?php

namespace Theme\Controller;

use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use Theme\Controller\AppController;
use Theme\Form\ContactForm;

/**
 * Pages Controller
 *
 * @property \Theme\Model\Table\PagesTable $Pages
 * @property \Admin\Model\Table\EmailTemplatesTable $EmailTemplates
 * @property \Admin\Model\Table\EmailQueuesTable $EmailQueues
 *
 * @method \Theme\Model\Entity\Page[] paginate($object = null, array $settings = [])
 */
class PagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
        $this->loadComponent('Recaptcha.Recaptcha', [
            'enable' => true,
            'sitekey' => $this->store->google_recaptcha_site_key,
            'secret' => $this->store->google_recaptcha_secret_key,
            'type' => 'image',
            'theme' => 'light',
            'lang' => 'pt-BR',
            'size' => 'normal'
        ]);

		$this->EmailTemplates = TableRegistry::get('Admin.EmailTemplates');
		$this->EmailQueues = TableRegistry::get('Admin.EmailQueues');
    }

    /**
     * @param $slug
     */
    public function view($slug)
    {
        $page = $this->Pages->find()
            ->where(['slug' => $slug])
            ->limit(1)
            ->first();

        $this->_bodyClass = 'produtos style-2';
        $this->pageTitle = $page->name;
        $this->set('page', $page);
        $this->set('_serialize', ['page']);
    }

    public function contact()
    {
        $contact = new ContactForm();

        if ($this->request->is(['post', 'put'])) {
            $template = $this->EmailTemplates->find()
                ->where(['slug' => 'contato'])
                ->first();

            if ($this->Recaptcha->verify()) {
				$session = new Session();
				$store = $session->read('Store');

				$data = $this->request->getData();
				$html = $this->EmailTemplates->buildHtml($template, $data);

				$email = $this->EmailQueues->newEntity([
					'from_name' => $store->name,
					'from_email' => $store->email_contact,
					'reply_name' => $data['name'],
					'reply_email' => $data['email'],
					'subject' => $template->subject,
					'content' => $html,
					'to_name' => $store->name,
					'to_email' => $store->email_contact,
					'email_statuses_id' => 1,
				]);

				if ($this->EmailQueues->save($email)) {
					$this->Flash->success(__('Sua mensagem foi enviada com sucesso. Em breve retornaremos, obrigado!'));
					return $this->redirect(['controller' => 'pages', 'action' => 'contact']);
				}

				$this->Flash->error(__("Ocorreu um problema ao enviar sua mensagem. Por favor, tente novamente"));
            }
            $this->Flash->error(__("Você precisa confirmar que não é um robo."));
        }

        $states = ['AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM', 'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES', 'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS', 'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR', 'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN', 'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC', 'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO'];

        $this->pageTitle = __('Fale Conosco');
        $this->_bodyClass = 'fale-conosco';
        $this->set(compact('contact', 'states'));
    }

    public function concept()
	{
		$this->pageTitle = __('Conceito');
		$this->_bodyClass = 'conceito';

		$page = $this->getPage('conceito');
		$this->set(compact('page'));
	}

    public function whereFind()
    {
        $this->pageTitle = __('Onde Encontrar');
        $this->_bodyClass = 'onde-encontrar';

        $page = $this->getPage('onde-encontrar');
        $this->set(compact('page'));
    }

    public function partner()
    {
        $this->pageTitle = __('Seja um Licenciado');
        $this->_bodyClass = 'seja-um-parceiro';

        $page = $this->getPage('seja-um-licenciado');
        $this->set(compact('page'));
    }

    public function professionalLine()
    {
        $this->pageTitle = __('Linha profissional');
        $this->_bodyClass = 'produtos style-2 linha-profissional';

        $page = $this->getPage('linha-profissional');
        $this->set(compact('page'));
    }

    private function getPage($slug)
    {
        return $this->Pages->find()
            ->where(['slug' => $slug])
            ->limit(1)
            ->first();
    }
}
