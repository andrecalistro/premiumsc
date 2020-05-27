<?php

use Migrations\AbstractMigration;

class CreateIndexes extends AbstractMigration
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
        $this->table('customers')
            ->addIndex('deleted')
            ->save();

        $this->table('customers_addresses')
            ->addIndex('customers_id')
            ->save();

        $this->table('orders')
            ->addIndex('customers_id')
            ->addIndex('customers_addresses_id')
            ->addIndex('deleted')
            ->save();

        $this->table('orders_products')
            ->addIndex('products_id')
            ->addIndex('orders_id')
            ->addIndex('deleted')
            ->save();
    }
}
