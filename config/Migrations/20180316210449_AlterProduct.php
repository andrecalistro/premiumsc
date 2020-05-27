<?php

use Migrations\AbstractMigration;

class AlterProduct extends AbstractMigration
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
        $table = $this->table('products');

        $table->addColumn('expiration_date', 'datetime', [
            'default' => null,
            'null' => true,
            'after' => 'products_conditions_id'
        ])
            ->addColumn('release_date', 'datetime', [
                'default' => null,
                'null' => true,
                'after' => 'expiration_date'
            ])
            ->addColumn('additional_delivery_time', 'integer', [
                'default' => null,
                'null' => true,
                'after' => 'release_date'
            ]);

        $table->update();
    }
}
