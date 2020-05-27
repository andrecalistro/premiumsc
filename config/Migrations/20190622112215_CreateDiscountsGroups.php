<?php

use Migrations\AbstractMigration;

class CreateDiscountsGroups extends AbstractMigration
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
        $table = $this->table('discounts_groups');
        $table->addColumn('name', 'string', [
            'limit' => 255,
            'null' => false,
        ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('free_shipping', 'integer', [
                'default' => null,
                'limit' => 1,
                'null' => false,
            ])
            ->addColumn('discount', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('status', 'integer', [
                'default' => 0,
                'limit' => 11,
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
            ->addIndex('status')
            ->addIndex('created')
            ->addIndex('modified')
            ->addIndex('deleted')
            ->create();

        $table = $this->table('discount_group_customers');
        $table->addColumn('customers_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ])
            ->addColumn('discounts_groups_id', 'integer', [
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('period', 'date', [
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

        $this->table('discount_group_customers')
            ->addIndex('customers_id')
            ->addIndex('discounts_groups_id')
            ->addIndex('created')
            ->addIndex('modified')
            ->addIndex('deleted')
//            ->addForeignKey('discounts_groups_id', 'discounts_groups', 'id', [
//                'delete' => 'NO_ACTION',
//                'update' => 'NO_ACTION'
//            ])
//            ->addForeignKey('customers_id', 'customers', 'id', [
//                'delete' => 'NO_ACTION',
//                'update' => 'NO_ACTION'
//            ])
            ->save();

        $table = $this->table('discount_group_products');
        $table->addColumn('discounts_groups_id', 'integer', [
            'limit' => 11,
            'null' => false,
        ])
            ->addColumn('products_id', 'integer', [
                'limit' => 11,
                'null' => false,
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

        $this->table('discount_group_products')
            ->addIndex('products_id')
            ->addIndex('discounts_groups_id')
            ->addIndex('created')
            ->addIndex('modified')
            ->addIndex('deleted')
//            ->addForeignKey('discounts_groups_id', 'discounts_groups', 'id', [
//                'delete' => 'NO_ACTION',
//                'update' => 'NO_ACTION'
//            ])
//            ->addForeignKey('products_id', 'products', 'id', [
//                'delete' => 'NO_ACTION',
//                'update' => 'NO_ACTION'
//            ])
            ->save();

        $this->execute('DELETE FROM stores WHERE code = "discounts_groups"');
    }
}
