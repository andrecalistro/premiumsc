<?php

use Migrations\AbstractMigration;

class AlterColumnSentDateOrder extends AbstractMigration
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
        $table = $this->table('orders');
        $table->changeColumn('shipping_sent_date', 'date');
        $table->update();
    }
}
