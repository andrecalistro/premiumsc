<?php
use Migrations\AbstractMigration;

class CreateCoupons extends AbstractMigration
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
        $table = $this->table('coupons');

		$table
			->addColumn('name', 'string', [
				'default' => null,
				'null' => true,
				'limit' => 255,
			])
			->addColumn('description', 'text', [
				'default' => null,
				'null' => true,
				'limit' => null,
			])
			->addColumn('code', 'string', [
				'default' => null,
				'null' => true,
				'limit' => 255,
			])
			->addColumn('type', 'string', [
				'default' => null,
				'null' => true,
				'limit' => 255,
			])
			->addColumn('value', 'decimal', [
				'default' => null,
				'null' => true,
				'precision' => 15,
				'scale' => 2,
			])
			->addColumn('free_shipping', 'boolean', [
				'default' => false,
				'null' => false,
				'limit' => null,
			])
			->addColumn('release_date', 'datetime', [
				'default' => null,
				'null' => true,
			])
			->addColumn('expiration_date', 'datetime', [
				'default' => null,
				'null' => true,
			])
			->addColumn('min_value', 'decimal', [
				'default' => null,
				'null' => true,
				'precision' => 15,
				'scale' => 2,
			])
			->addColumn('max_value', 'decimal', [
				'default' => null,
				'null' => true,
				'precision' => 15,
				'scale' => 2,
			])
			->addColumn('only_individual_use', 'boolean', [
				'default' => false,
				'null' => false,
				'limit' => null,
			])
			->addColumn('exclude_promotional_items', 'boolean', [
				'default' => false,
				'null' => false,
				'limit' => null,
			])
			->addColumn('products_ids', 'text', [
				'default' => null,
				'null' => true,
				'limit' => null,
			])
			->addColumn('excluded_products_ids', 'text', [
				'default' => null,
				'null' => true,
				'limit' => null,
			])
			->addColumn('categories_ids', 'text', [
				'default' => null,
				'null' => true,
				'limit' => null,
			])
			->addColumn('excluded_categories_ids', 'text', [
				'default' => null,
				'null' => true,
				'limit' => null,
			])
			->addColumn('restricted_emails_list', 'text', [
				'default' => null,
				'null' => true,
				'limit' => null,
			])
			->addColumn('use_limit', 'integer', [
				'default' => null,
				'null' => true,
				'limit' => 11,
			])
			->addColumn('used_limit', 'integer', [
				'default' => 0,
				'null' => true,
				'limit' => 11,
			])
			->addColumn('customer_use_limit', 'integer', [
				'default' => null,
				'null' => true,
				'limit' => 11,
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