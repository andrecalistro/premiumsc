<?php
use Migrations\AbstractMigration;

class InsertEmailTemplateNewCustomer extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $date = date('Y-m-d H:i:s');
        $this->table('email_templates')
            ->insert([
                [
                    'name' => 'Novo cadastro',
                    'slug' => 'novo-cadastro',
                    'subject' => 'Seja bem vindo(a)!',
                    'from_name' => 'Contato Loja',
                    'from_email' => 'contato@nerdweb.com.br',
                    'who_receives' => 'customer',
                    'header' => '',
                    'footer' => '',
                    'tags' => '{"name": "[NOME]","email": "[EMAIL]","store_name": "[NOME_LOJA]","store_cellphone": "[CELULAR_LOJA]","store_telephone": "[TELEFONE_LOJA]", "store_email":"[EMAIL_LOJA]", "store_account_link":"[LINK_CONTA]"}',
                    'content' =>
                        '<table style="font-family: \'Arial\', sans-serif; margin-bottom: 100px; font-size: 15px;" border="0" width="600" cellspacing="0" cellpadding="0" align="center">
                        <tbody>
                        <tr>
                        <td style="background-color: #f4f4f4; padding: 5px;">
                        <p style="font-size: 18px; font-weight: bold; margin: 0 0 10px;">Olá, [NOME]</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="padding: 5px;">
                        <p style="margin: 0 0 20px;">Seja muito bem vindo(a). Acesse sua conta clicando <a href="[LINK_CONTA]">aqui</a>, então informe seu e-mail/CPF e senha.</p>
                        <p style="margin: 0 0 20px;">Quando acessar sua conta, você poderá:</p>
                        <p>Fechar compras com maior agilidade<br />Acompanhar seus pedidos<br />Visualizar histórico de pedidos<br />Alterar informações de conta<br />Alterar sua senha<br />Cadastrar novos endereços de entrega</p>
                        </td>
                        </tr>
                        <tr>
                        <td style="background-color: #f4f4f4; padding: 5px;">
                        <p>Se você tiver alguma dúvida sobre sua conta ou qualquer outra informação do site, não deixe de entrar em contato através do email [EMAIL_LOJA] ou por telefone [CELULAR_LOJA] / [TELEFONE_LOJA].</p>
                        </td>
                        </tr>
                        </tbody>
                        </table>',
                    'created' => $date,
                    'modified' => $date
                ]
            ])
            ->save();
    }
}
