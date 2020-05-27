<?php

use Migrations\AbstractMigration;

class CreateOrdersProductsVariations extends AbstractMigration
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
        $table = $this->table('orders_products_variations')
            ->addPrimaryKey('id')
            ->addColumn('orders_id', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => 11
            ])
            ->addColumn('orders_products_id', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => 11
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => 11
            ])
            ->addColumn('variations_id', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => 11
            ])
            ->addColumn('variations_sku', 'string', [
                'default' => null,
                'null' => true,
                'after' => 'variations_id',
                'limit' => 255
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'null' => true,
                'limit' => 11
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true
            ]);

        $table->create();

        $table = $this->table('carts')
            ->addColumn('variations_id', 'integer', [
                'default' => null,
                'null' => true,
                'after' => 'products_id'
            ])
            ->addColumn('variations_sku', 'string', [
                'default' => null,
                'null' => true,
                'after' => 'variations_id',
                'limit' => 255
            ]);

        $table->update();

        $table = $this->table('products_variations')
            ->addColumn('sku', 'string', [
                'default' => null,
                'null' => true,
                'after' => 'stock',
                'limit' => 255
            ]);

        $table->update();
    }
}
