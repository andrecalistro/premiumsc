<?php

use Migrations\AbstractMigration;

class AlterCustomersCompanies extends AbstractMigration
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
        if ($table->exists()) {
            $table->drop();
        }

        $table = $this->table('customers_types')
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 255
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
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
        $table->addIndex('deleted')
            ->save();

        $date = \Cake\I18n\Time::now('America/Sao_Paulo')->format('Y-m-d H:i:s');
        $table->insert([
            [
                'name' => 'Pessoa Física',
                'slug' => 'pessoa-fisica',
                'created' => $date,
                'modified' => $date
            ],
            [
                'name' => 'Pessoa Jurídica',
                'slug' => 'pessoa-juridica',
                'created' => $date,
                'modified' => $date
            ]
        ])
            ->save();

        $this->table('customers')
            ->addColumn('customers_types_id', 'integer', [
                'default' => 1,
                'null' => true,
                'after' => 'id'
            ])
            ->addColumn('company_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'gender',
            ])
            ->addColumn('trading_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'company_name'
            ])
            ->addColumn('company_state', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'trading_name'
            ])
            ->addColumn('company_document', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'company_state'
            ])
            ->addColumn('company_document_clean', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'company_document'
            ])
            ->save();
    }
}
