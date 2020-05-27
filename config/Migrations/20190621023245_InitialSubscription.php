<?php

use Migrations\AbstractMigration;

class InitialSubscription extends AbstractMigration
{
    /**
     * @throws Exception
     */
    public function change()
    {
        try {
            $this->table('plan_delivery_frequencies')
                ->addColumn('name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255,
                ])
                ->addColumn('days', 'integer', [
                    'default' => 1,
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('plan_billing_frequencies')
                ->addColumn('name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255,
                ])
                ->addColumn('days', 'integer', [
                    'default' => 1,
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('plans')
                ->addColumn('name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255,
                ])
                ->addColumn('frequency_delivery_id', 'integer', [
                    'limit' => 11,
                    'null' => true,
                ])
                ->addColumn('frequency_billing_id', 'integer', [
                    'limit' => 11,
                    'null' => true,
                ])
                ->addColumn('status', 'integer', [
                    'null' => false,
                    'limit' => 1,
                    'default' => 1
                ])
                ->addColumn('due_at', 'date', [
                    'null' => true,
                    'default' => null
                ])
                ->addColumn('price', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 2,
                ])
                ->addColumn('description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('weight', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 3,
                ])
                ->addColumn('length', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 3,
                ])
                ->addColumn('width', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 3,
                ])
                ->addColumn('height', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 3,
                ])
                ->addColumn('shipping_required', 'integer', [
                    'default' => '0',
                    'limit' => 1,
                    'null' => true,
                ])
                ->addColumn('shipping_free', 'integer', [
                    'default' => '0',
                    'limit' => 1,
                    'null' => true,
                ])
                ->addColumn('seo_title', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('seo_description', 'text', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('seo_url', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('seo_image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('pagseguro_reference', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('plans')
                ->addIndex('name')
                ->addIndex('frequency_delivery_id')
                ->addIndex('frequency_billing_id')
                ->addIndex('created')
                ->addIndex('deleted')
                ->addForeignKey('frequency_delivery_id', 'plan_delivery_frequencies', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->addForeignKey('frequency_billing_id', 'plan_billing_frequencies', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->save();

            $this->table('plans_images')
                ->addColumn('plans_id', 'integer', [
                    'default' => null,
                    'limit' => 11,
                    'null' => true,
                ])
                ->addColumn('image', 'string', [
                    'default' => null,
                    'limit' => 255,
                    'null' => true,
                ])
                ->addColumn('main', 'integer', [
                    'default' => '0',
                    'limit' => 11,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('plans_images')
                ->addIndex('image')
                ->addIndex('created')
                ->addIndex('deleted')
                ->save();

            $this->table('plan_delivery_frequencies')
                ->insert([
                    [
                        'name' => 'Semanal',
                        'days' => 7,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Mensal',
                        'days' => 30,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Trimestral',
                        'days' => 90,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Semestral',
                        'days' => 180,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Anual',
                        'days' => 360,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ]
                ])
                ->saveData();

            $this->table('plan_billing_frequencies')
                ->insert([
                    [
                        'name' => 'Semanal',
                        'days' => 7,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Mensal',
                        'days' => 30,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Trimestral',
                        'days' => 90,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Semestral',
                        'days' => 180,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Anual',
                        'days' => 360,
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ]
                ])
                ->saveData();

            $this->table('subscriptions')
                ->addColumn('customers_id', 'integer', [
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('customers_addresses_id', 'integer', [
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('plans_id', 'integer', [
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('plans_name', 'string', [
                    'null' => false,
                    'limit' => 255,
                ])
                ->addColumn('plans_image', 'string', [
                    'null' => true,
                    'limit' => 255,
                    'default' => null
                ])
                ->addColumn('plans_thumb_image', 'string', [
                    'null' => true,
                    'limit' => 255,
                    'default' => null
                ])
                ->addColumn('status', 'integer', [
                    'default' => 1,
                    'null' => false,
                    'limit' => 1,
                ])
                ->addColumn('frequency_billing_days', 'integer', [
                    'default' => 1,
                    'null' => false,
                    'limit' => 11
                ])
                ->addColumn('frequency_billing_name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255
                ])
                ->addColumn('frequency_delivery_days', 'integer', [
                    'default' => 1,
                    'null' => false,
                    'limit' => 11
                ])
                ->addColumn('frequency_delivery_name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255
                ])
                ->addColumn('payment_component', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255
                ])
                ->addColumn('payment_method', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255
                ])
                ->addColumn('shipping_method', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255
                ])
                ->addColumn('price', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 2,
                ])
                ->addColumn('price_shipping', 'decimal', [
                    'default' => null,
                    'null' => true,
                    'precision' => 15,
                    'scale' => 2,
                ])
                ->addColumn('code', 'string', [
                    'null' => true,
                    'limit' => 255,
                    'default' => null
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('subscriptions')
                ->addIndex('customers_id')
                ->addIndex('customers_addresses_id')
                ->addIndex('plans_id')
                ->addIndex('created')
                ->addIndex('deleted')
                ->addForeignKey('customers_id', 'customers', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->addForeignKey('customers_addresses_id', 'customers_addresses', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->addForeignKey('plans_id', 'plans', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->save();

            $this->table('subscription_billing_status')
                ->addColumn('name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('subscription_billing_status')
                ->insert([
                    [
                        'name' => 'Próximo pagamento',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Pagamento pendente',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Pagamento Aprovado',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Pagamento Recusado',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ]
                ])
                ->saveData();

            $this->table('subscription_billings')
                ->addColumn('subscriptions_id', 'integer', [
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('payment_method', 'string', [
                    'null' => false,
                    'limit' => 255,
                ])
                ->addColumn('status_id', 'integer', [
                    'null' => true,
                    'limit' => 11,
                    'default' => null
                ])
                ->addColumn('status_text', 'string', [
                    'null' => true,
                    'default' => null,
                    'limit' => 255
                ])
                ->addColumn('payment_component', 'string', [
                    'null' => true,
                    'default' => null,
                    'limit' => 255
                ])
                ->addColumn('payment_code', 'string', [
                    'null' => true,
                    'default' => null,
                    'limit' => 255
                ])
                ->addColumn('date_process', 'date', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('subscription_shipping_status')
                ->addColumn('name', 'string', [
                    'default' => null,
                    'null' => true,
                    'limit' => 255,
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('subscription_billings')
                ->addIndex('subscriptions_id')
                ->addIndex('status_id')
                ->addIndex('created')
                ->addIndex('deleted')
                ->addForeignKey('subscriptions_id', 'subscriptions', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->addForeignKey('status_id', 'subscription_billing_status', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->save();

            $this->table('subscription_shipping_status')
                ->insert([
                    [
                        'name' => 'Aguardando envio',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Enviado',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Entregue',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Cancelado',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ]
                ])
                ->saveData();

            $this->table('subscription_shipments')
                ->addColumn('subscriptions_id', 'integer', [
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('shipping_method', 'string', [
                    'null' => false,
                    'limit' => 255,
                ])
                ->addColumn('status_id', 'integer', [
                    'null' => false,
                    'limit' => 11,
                ])
                ->addColumn('status_text', 'string', [
                    'null' => true,
                    'default' => null,
                    'limit' => 255
                ])
                ->addColumn('created', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('modified', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->addColumn('deleted', 'datetime', [
                    'default' => null,
                    'limit' => null,
                    'null' => true,
                ])
                ->create();

            $this->table('subscription_shipments')
                ->addIndex('subscriptions_id')
                ->addIndex('status_id')
                ->addIndex('created')
                ->addIndex('deleted')
                ->addForeignKey('subscriptions_id', 'subscriptions', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->addForeignKey('status_id', 'subscription_shipping_status', 'id', [
                    'delete' => 'NO_ACTION',
                    'update' => 'NO_ACTION'
                ])
                ->save();

            $this->execute('DELETE FROM stores WHERE code = "subscriptions"');
            $this->execute('UPDATE menus SET status = 0 WHERE id = 7');
            $this->execute('UPDATE menus SET name = "Planos", controller = "plans", action = "index", status = 0 WHERE id = 8');
            $this->execute('UPDATE menus SET name = "Assinantes", controller = "plans", action = "subscriptions", status = 0 WHERE id = 9');


            $this->table('email_templates')
                ->insert([
                    [
                        'name' => 'Nova assinatura',
                        'slug' => 'nova-assintaura',
                        'subject' => 'Obrigado por assinar nosso plano',
                        'from_name' => 'Contato Loja',
                        'from_email' => 'contato@nerdweb.com.br',
                        'who_receives' => NULL,
                        'header' => '',
                        'footer' => '',
                        'tags' => \GuzzleHttp\json_encode([
                            'name' => '[NOME]',
                            'plan' => '[PLANO]',
                            'payment_method' => '[FORMA_PAGAMENTO]',
                            'billing_frequency' => '[FREQUENCIA_COBRANCA]',
                            'delivery_frequency' => '[FREQUENCIA_ENVIO]',
                            'total_subscription' => '[VALOR_ASSINATURA]',
                            'total_shipment' => '[VALOR_FRETE]',
                            'total' => '[VALOR_TOTAL]',
                            'link' => '[URL_ASSINATURA]',
                            'email_sac' => '[EMAIL_SAC]'
                        ]),
                        'content' =>
                            '<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" border="0" width="600" cellspacing="0" cellpadding="0"
       align="center">
    <tbody>
    <tr>
        <td>
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Olá [NOME],</p>
            <p style="margin: 0 0 20px;">Obrigado por assinar o plano [PLANO].</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 1px;"> </td>
    </tr>
    <tr>
        <td style="background-color: #f4f4f4; padding: 15px;">
            <p><strong>INFORMAÇÔES DA SUA ASSINATURA</strong></p>
            <p><strong>Plano:</strong> [PLANO]</p>
            <p><strong>Forma de pagamento:</strong> [FORMA_PAGAMENTO]</p>
            <p><strong>Frequência de cobrança:</strong> [FREQUENCIA_COBRANCA]</p>
            <p><strong>Frequência de envio:</strong> [FREQUENCIA_ENVIO]</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td>
            <table border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
                        <p>VALOR DA ASSINATURA:</p>
                    </td>
                    <td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
                        <p>[VALOR_ASSINATURA]</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 1px;"> </td>
                </tr>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
                        <p>VALOR DO FRETE:</p>
                    </td>
                    <td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
                        <p>[VALOR_FRETE]</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 1px;"> </td>
                </tr>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="background-color: #e3e3e3; padding: 15px;" colspan="4">
                        <p>TOTAL:</p>
                    </td>
                    <td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
                        <p>[VALOR_TOTAL]</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td style="background-color: #f4f4f4; padding: 20px; text-align: center;"><a href="[URL_ASSINATURA]" target="_blank"
                                                                                     rel="noopener">Clique aqui e
                acompanhe a sua assinatura.</a></td>
    </tr>
    <tr>
        <td>
            <p style="padding: 30px 0px 0px; text-align: left;">Em caso de dúvidas favor entrar em contato com nosso SAC
                através do e-mail [EMAIL_SAC].</p>
        </td>
    </tr>
    </tbody>
</table>',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Produto assinatura enviado',
                        'slug' => 'produto-assinatura-enviado',
                        'subject' => 'Seu produto foi enviado!',
                        'from_name' => 'Contato Loja',
                        'from_email' => 'contato@nerdweb.com.br',
                        'who_receives' => NULL,
                        'header' => '',
                        'footer' => '',
                        'tags' => \GuzzleHttp\json_encode([
                            'name' => '[NOME]',
                            'plan' => '[PLANO]',
                            'code' => '[CODIGO]',
                            'email_sac' => '[EMAIL_SAC]'
                        ]),
                        'content' =>
                            '<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" border="0" width="600" cellspacing="0" cellpadding="0"
       align="center">
    <tbody>
    <tr>
        <td>
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Olá [NOME],</p>
            <p style="margin: 0 0 20px;">Seu produto do plano [PLANO] foi enviado.</p>
            <p style="margin: 0 0 20px;">O código de rastreio é [CODIGO].</p>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td>
            <p style="padding: 30px 0px 0px; text-align: left;">Em caso de dúvidas favor entrar em contato com nosso SAC
                através do e-mail [EMAIL_SAC].</p>
        </td>
    </tr>
    </tbody>
</table>',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Falha na cobraça da assinatura',
                        'slug' => 'falha-cobranca-assinatura',
                        'subject' => 'Ocorreu um problema com a sua assinatura',
                        'from_name' => 'Contato Loja',
                        'from_email' => 'contato@nerdweb.com.br',
                        'who_receives' => NULL,
                        'header' => '',
                        'footer' => '',
                        'tags' => \GuzzleHttp\json_encode([
                            'name' => '[NOME]',
                            'link' => '[URL_ASSINATURA]',
                            'email_sac' => '[EMAIL_SAC]'
                        ]),
                        'content' =>
                            '<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" border="0" width="600" cellspacing="0" cellpadding="0"
       align="center">
    <tbody>
    <tr>
        <td>
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Olá [NOME],</p>
            <p style="margin: 0 0 20px;">A cobrança do seu plano falhou, <a href="[URL_ASSINATURA]" target="_blank"
                                                                                     rel="noopener">Clique aqui e
                gerencie sua assinatura.</a>.</p>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td>
            <p style="padding: 30px 0px 0px; text-align: left;">Em caso de dúvidas favor entrar em contato com nosso SAC
                através do e-mail [EMAIL_SAC].</p>
        </td>
    </tr>
    </tbody>
</table>',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Nova cobrança assinatura',
                        'slug' => 'nova-cobranca-assinatura',
                        'subject' => 'Seu pagamento foi aprovado!',
                        'from_name' => 'Contato Loja',
                        'from_email' => 'contato@nerdweb.com.br',
                        'who_receives' => NULL,
                        'header' => '',
                        'footer' => '',
                        'tags' => \GuzzleHttp\json_encode([
                            'name' => '[NOME]',
                            'plan' => '[PLANO]',
                            'total_subscription' => '[VALOR_ASSINATURA]',
                            'total_shipment' => '[VALOR_FRETE]',
                            'total' => '[VALOR_TOTAL]',
                            'link' => '[URL_ASSINATURA]',
                            'email_sac' => '[EMAIL_SAC]'
                        ]),
                        'content' =>
                            '<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" border="0" width="600" cellspacing="0" cellpadding="0"
       align="center">
    <tbody>
    <tr>
        <td>
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Olá [NOME],</p>
            <p style="margin: 0 0 20px;">Seu pagamento do plano [PLANO] foi realizado.</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td>
            <table border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
                        <p>VALOR DA ASSINATURA:</p>
                    </td>
                    <td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
                        <p>[VALOR_ASSINATURA]</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 1px;"> </td>
                </tr>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="background-color: #f4f4f4; padding: 15px;" colspan="4">
                        <p>VALOR DO FRETE:</p>
                    </td>
                    <td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
                        <p>[VALOR_FRETE]</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 1px;"> </td>
                </tr>
                <tr style="font-weight: bold; font-size: 16px;">
                    <td style="background-color: #e3e3e3; padding: 15px;" colspan="4">
                        <p>TOTAL:</p>
                    </td>
                    <td style="background-color: #e3e3e3; padding: 15px; border-left: 2px solid #fff;">
                        <p>[VALOR_TOTAL]</p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td style="background-color: #f4f4f4; padding: 20px; text-align: center;"><a href="[URL_ASSINATURA]" target="_blank"
                                                                                     rel="noopener">Clique aqui e
                acompanhe a sua assinatura.</a></td>
    </tr>
    <tr>
        <td>
            <p style="padding: 30px 0px 0px; text-align: left;">Em caso de dúvidas favor entrar em contato com nosso SAC
                através do e-mail [EMAIL_SAC].</p>
        </td>
    </tr>
    </tbody>
</table>',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ],
                    [
                        'name' => 'Assinatura cancelada',
                        'slug' => 'assinatura-cancelada',
                        'subject' => 'Seu assinatura foi cancelada',
                        'from_name' => 'Contato Loja',
                        'from_email' => 'contato@nerdweb.com.br',
                        'who_receives' => NULL,
                        'header' => '',
                        'footer' => '',
                        'tags' => \GuzzleHttp\json_encode([
                            'name' => '[NOME]',
                            'plan' => '[PLANO]',
                            'link' => '[URL_ASSINATURA]',
                            'email_sac' => '[EMAIL_SAC]'
                        ]),
                        'content' =>
                            '<table style="font-family: \'Arial\', sans-serif; font-size: 15px;" border="0" width="600" cellspacing="0" cellpadding="0"
       align="center">
    <tbody>
    <tr>
        <td>
            <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Olá [NOME],</p>
            <p style="margin: 0 0 20px;">Sua assinatura do plano [PLANO] foi cancelada.</p>
    </tr>
    <tr>
        <td style="padding: 10px;"> </td>
    </tr>
    <tr>
        <td>
            <p style="padding: 30px 0px 0px; text-align: left;">Em caso de dúvidas favor entrar em contato com nosso SAC
                através do e-mail [EMAIL_SAC].</p>
        </td>
    </tr>
    </tbody>
</table>',
                        'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                        'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                    ]
                ])
                ->save();
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
