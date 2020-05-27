<?php

use Migrations\AbstractMigration;

class CreateNotesOrder extends AbstractMigration
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
        $table->addColumn('notes', 'text', [
            'default' => null,
            'null' => true,
            'after' => 'coupon_discount'
        ]);
        $table->update();
    }
}
