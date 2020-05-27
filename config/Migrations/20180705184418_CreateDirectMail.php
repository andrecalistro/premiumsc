<?php

use Migrations\AbstractMigration;

class CreateDirectMail extends AbstractMigration
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
        $this->table('directs_mails')
            ->addColumn('name', 'string', [
                'limit' => 255,
                'default' => null,
                'null' => true
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
            ])
            ->create();

        $this->table('directs_mails_customers')
            ->addColumn('directs_mails_id', 'integer', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('customers_id', 'integer', [
                'default' => null,
                'null' => true
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
            ])
            ->create();

        $this->table('directs_mails_products')
            ->addColumn('directs_mails_id', 'integer', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('products_id', 'integer', [
                'default' => null,
                'null' => true
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
            ])
            ->create();
    }
}
