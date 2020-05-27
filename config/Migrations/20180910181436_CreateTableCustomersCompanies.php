<?php
use Migrations\AbstractMigration;

class CreateTableCustomersCompanies extends AbstractMigration
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
        $table = $this->table('customers_companies');
        $table->addColumn('customers_id', 'integer', [
            'default' => null,
            'null' => true
        ])
            ->addColumn('company_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('trading_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('company_state', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('document', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('address', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('zipcode', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('number', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('complement', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('neighborhood', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ]);
        $table->create();
    }
}
