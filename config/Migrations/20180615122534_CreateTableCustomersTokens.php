<?php

use Migrations\AbstractMigration;

class CreateTableCustomersTokens extends AbstractMigration
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
        $table = $this->table('customers_tokens');

        $table->addColumn('customers_id', 'integer', [
            'default' => null,
            'null' => true
        ])
            ->addColumn('token', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('validate', 'datetime', [
                'default' => null,
                'null' => true,
                'limit' => null,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => true,
                'limit' => null,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => true,
                'limit' => null,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => true,
                'limit' => null,
            ]);

        $table->create();
    }
}
