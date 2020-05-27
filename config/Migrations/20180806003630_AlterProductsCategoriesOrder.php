<?php

use Migrations\AbstractMigration;

class AlterProductsCategoriesOrder extends AbstractMigration
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
        $table = $this->table('products_categories');

        $table->addColumn('order_show', 'integer', [
            'default' => 0,
            'null' => true,
            'after' => 'categories_id'
        ]);

        $table->update();
    }
}
