<?php

namespace Theme\Form;

use Cake\Core\Configure;
use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\Email;
use Cake\Network\Session;
use Cake\Validation\Validator;

/**
 * Contact Form.
 */
class ContactForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'email'])
            ->addField('telephone', 'string')
            ->addField('state', ['type' => 'select'])
            ->addField('city', 'string')
            ->addField('department', 'string')
            ->addField('message', 'text');
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        return $validator->notEmpty('name', __('Por favor, preencha seu nome.'))
            ->email('email', false, __('Por favor, insira um e-mail válido.'))
            ->notEmpty('email', __('Por favor, preencha seu e-mail.'))
            ->notEmpty('message', __('Por favor, preencha sua mensagem.'));
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function _execute(array $data)
    {
        $session = new Session();
        $store = $session->read('Store');
        $mail = new Email();
        $mail->setTransport('nerdweb')
            ->setEmailFormat('html')
            ->setTemplate(Configure::read('Theme') . '.contact')
            ->setReplyTo($data['email'], $data['name'])
            ->setFrom($store->email_contact, $store->name)
            ->setTo($store->email_contact, $store->name)
            ->setSubject(__('Nova mensagem da Loja'))
            ->setViewVars([
                'data' => $data
            ]);

        if ($mail->send()) {
            return true;
        }
        return false;
    }
}
