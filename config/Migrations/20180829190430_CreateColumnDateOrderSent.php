<?php

use Migrations\AbstractMigration;

class CreateColumnDateOrderSent extends AbstractMigration
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
        $this->table('orders')
            ->addColumn('shipping_sent_date', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'after' => 'shipping_required'
            ])
            ->save();
    }
}
