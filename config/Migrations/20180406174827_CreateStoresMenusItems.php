<?php
use Migrations\AbstractMigration;

class CreateStoresMenusItems extends AbstractMigration
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
        $table = $this->table('stores_menus_items');

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
			->addColumn('menu_type', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('url', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('target', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('icon_class', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('icon_image', 'string', [
				'default' => null,
				'limit' => 255,
				'null' => true,
			])
			->addColumn('parent_id', 'integer', [
				'default' => null,
				'limit' => 11,
				'null' => true,
			])
			->addColumn('status', 'integer', [
				'default' => null,
				'limit' => 11,
				'null' => true,
			])
			->addColumn('position', 'integer', [
				'default' => null,
				'limit' => 11,
				'null' => true,
			])
			->addColumn('stores_menus_groups_id', 'integer', [
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