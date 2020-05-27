<?php
use Migrations\AbstractMigration;

class AddCountryToCustomersAddresses extends AbstractMigration
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
        $table = $this->table('customers_addresses');

		$table->addColumn('country', 'string', [
			'default' => 'Brasil',
			'limit' => null,
			'null' => true,
			'after' => 'state'
		]);

        $table->update();
    }
}