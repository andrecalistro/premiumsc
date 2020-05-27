<?php
use Migrations\AbstractMigration;

class AddReleaseAndExpirationDateToCategories extends AbstractMigration
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
        $table = $this->table('categories');

		$table
			->addColumn('release_date', 'datetime', [
				'default' => null,
				'null' => true,
				'after' => 'show_launch_menu'
			])
			->addColumn('expiration_date', 'datetime', [
				'default' => null,
				'null' => true,
				'after' => 'release_date'
			]);

        $table->update();
    }
}
