<?php

use Migrations\AbstractMigration;

class CreateWishList extends AbstractMigration
{
    /**
     * @throws Exception
     */
    public function change()
    {
        $this->table('wish_list_statuses')
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

        $this->table('wish_list_statuses')
            ->insert([
                [
                    'name' => 'Ativa',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Inativa',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Finalizada',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Cancelada',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ]
            ])
            ->saveData();

        $this->table('wish_lists')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('wish_list_statuses_id', 'integer', [
                'default' => 0,
                'limit' => 1,
                'null' => true,
            ])
            ->addColumn('customers_id', 'integer', [
                'null' => false,
                'limit' => 11,
            ])
            ->addColumn('validate', 'datetime', [
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

        $this->table('wish_lists')
            ->addIndex('customers_id')
            ->addIndex('created')
            ->addIndex('modified')
            ->addIndex('deleted')
            ->addIndex('validate')
            ->addForeignKey('customers_id', 'customers', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->addForeignKey('wish_list_statuses_id', 'wish_list_statuses', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->save();

        $this->table('wish_list_product_statuses')
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

        $this->table('wish_list_product_statuses')
            ->insert([
                [
                    'name' => 'Não comprado',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Aguardando pagamento',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Comprado',
                    'created' => (new \DateTime())->format('Y-m-d H:i:s'),
                    'modified' => (new \DateTime())->format('Y-m-d H:i:s')
                ]
            ])
            ->saveData();

        $this->table('wish_list_products')
            ->addColumn('customers_id', 'integer', [
                'null' => true,
                'limit' => 11,
                'default' => null
            ])
            ->addColumn('products_id', 'integer', [
                'null' => false,
                'limit' => 11
            ])
            ->addColumn('wish_lists_id', 'integer', [
                'null' => false,
                'limit' => 11
            ])
            ->addColumn('orders_id', 'integer', [
                'null' => true,
                'limit' => 11,
                'default' => null
            ])
            ->addColumn('wish_list_product_statuses_id', 'integer', [
                'default' => 0,
                'limit' => 1,
                'null' => true
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
            ->addIndex('customers_id')
            ->addIndex('products_id')
            ->addIndex('wish_lists_id')
            ->addIndex('orders_id')
            ->addIndex('wish_list_product_statuses_id')
            ->addIndex('created')
            ->addIndex('modified')
            ->addIndex('deleted')
            ->addForeignKey('customers_id', 'customers', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
//            ->addForeignKey('products_id', 'products', 'id', [
//                'delete' => 'NO_ACTION',
//                'update' => 'NO_ACTION'
//            ])
            ->addForeignKey('wish_lists_id', 'wish_lists', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->addForeignKey('orders_id', 'orders', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->addForeignKey('wish_list_product_statuses_id', 'wish_list_product_statuses', 'id', [
                'delete' => 'NO_ACTION',
                'update' => 'NO_ACTION'
            ])
            ->create();

        $this->table('menus')
            ->insert([
                [
                    'name' => 'Módulos',
                    'icon' => null,
                    'parent_id' => 10,
                    'plugin' => 'admin',
                    'controller' => 'modules',
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
    }
}
