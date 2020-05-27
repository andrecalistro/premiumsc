<?php
use Migrations\AbstractMigration;

class AlterLendings extends AbstractMigration
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
        $table = $this->table('lendings');

        $table->addColumn('customer_document', 'string', [
            'default' => null,
            'null' => true,
            'limit' => 255,
            'after' => 'customer_email'
        ]);

        $table->update();
    }
}
