<?php
use Migrations\AbstractMigration;

class AddAuxiliaryFieldToProductsVariations extends AbstractMigration
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
        $table = $this->table('products_variations');

        $table->addColumn('auxiliary_field', 'text', [
			'default' => null,
			'limit' => null,
			'null' => true,
			'after' => 'image'
		]);

        $table->update();
    }
}
