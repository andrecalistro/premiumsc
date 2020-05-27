<?php

use Migrations\AbstractMigration;

class AddShippingControlProduct extends AbstractMigration
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
        $this->table('products')
            ->addColumn('shipping_control', 'integer', [
                'default' => 1,
                'null' => true,
                'after' => 'additional_delivery_time'
            ])
            ->update();

        $this->table('orders')
            ->addColumn('shipping_required', 'integer', [
                'default' => 1,
                'null' => true,
                'after' => 'notes'
            ])
            ->update();
    }
}
