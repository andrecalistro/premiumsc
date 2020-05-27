<?php
use Migrations\AbstractMigration;

class AddOriginToEmailsMarketings extends AbstractMigration
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
        $table = $this->table('emails_marketings');

		$table->addColumn('origin', 'integer', [
				'default' => 0,
				'null' => true,
				'after' => 'status'
			]);

        $table->update();
    }
}
