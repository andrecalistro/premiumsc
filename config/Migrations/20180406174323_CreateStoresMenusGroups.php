<?php
use Migrations\AbstractMigration;

class CreateStoresMenusGroups extends AbstractMigration
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
        $table = $this->table('stores_menus_groups');

		$table
			->addColumn('name', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('slug', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('status', 'integer', [
				'default' => null,
				'limit' => 11,
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