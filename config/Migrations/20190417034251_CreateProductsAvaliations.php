<?php
use Migrations\AbstractMigration;

class CreateProductsAvaliations extends AbstractMigration
{
    /**
     * @throws Exception
     */
    public function change()
    {
        $this->table('products_ratings')
            ->addColumn('customers_id', 'integer', [
                'null' => false,
                'limit' => 11,
            ])
            ->addColumn('orders_id', 'integer', [
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('products_id', 'integer', [
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('rating', 'integer', [
                'null' => false,
                'limit' => 11,
            ])
            ->addColumn('answer', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('products_ratings_statuses_id', 'integer', [
                'default' => 1,
                'limit' => 1,
                'null' => false
            ])
            ->addColumn('products_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('products_image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false
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

        $this->table('products_ratings_statuses')
            ->addColumn('name', 'string', [
                'default' => null,
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

        $this->table('products_ratings_statuses')
            ->insert([
                [
                    'name' => 'Aguardando Aprovação',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Aprovada',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Reprovada',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ]
            ])
            ->saveData();

        $this->table('menus')
            ->insert([
                [
                    'name' => 'Avaliações',
                    'icon' => null,
                    'parent_id' => 17,
                    'plugin' => 'admin',
                    'controller' => 'products_ratings',
                    'action' => 'index',
                    'params' => '',
                    'status' => 1,
                    'position' => 5,
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
            ])
            ->saveData();

        $row = $this->fetchRow('SELECT * FROM menus order by id desc limit 1');

        $this->table('rules_menus')
            ->insert([
                [
                    'rules_id' => 1,
                    'menus_id' => $row['id'],
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'rules_id' => 2,
                    'menus_id' => $row['id'],
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ]
            ])
            ->saveData();

        $this->table('products_ratings')
            ->addIndex('customers_id')
            ->addIndex('orders_id')
            ->addIndex('customers_id')
            ->addIndex('products_ratings_statuses_id')
            ->addIndex('modified')
            ->addIndex('created')
            ->addIndex('deleted')
            ->addForeignKey('customers_id', 'customers', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->addForeignKey('orders_id', 'orders', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
//            ->addForeignKey('products_id', 'products', 'id', [
//                'delete' => 'NO_ACTION',
//                'update' => 'NO_ACTION'
//            ])
            ->addForeignKey('products_ratings_statuses_id', 'products_ratings_statuses', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->save();

        $this->table('email_templates')
            ->insert([
                [
                    'name' => 'Avaliação de Produtos',
                    'slug' => 'avaliacao-de-produtos',
                    'subject' => 'Avalie nosso produtos',
                    'from_name' => 'Contato Loja',
                    'from_email' => 'contato@nerdweb.com.br',
                    'who_receives' => 'customer',
                    'header' => '',
                    'footer' => '',
                    'tags' => '{"name": "[NOME]","order": "[PEDIDO]","link": "[LINK]"}',
                    'content' =>
                        '<table style="font-family: \'Arial\', sans-serif; margin-bottom: 100px; font-size: 15px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
							<tbody>
								<tr>
									<td>
										<p style="font-size: 18px; font-weight: 700; margin: 0 0 10px;">Olá [NOME],</p>
										<p style="margin: 0 0 20px;">Sua opinião conta muito para nós!</p>
										<p style="margin: 0 0 20px;">Buscamos sempre melhor atendê-lo e por isso gostaríamos de saber como foi sua experiência de compra conosco. Clique no link abaixo:</p>
										<p style="margin: 0 0 20px;"><a href="[LINK]">Clique aqui para avaliar sua compra</a></p>
									</td>
								</tr>
							</tbody>
						</table>',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ]
            ])
            ->save();
    }
}
