<?php

use Migrations\AbstractMigration;

class AddColumnIpEmailsMarketings extends AbstractMigration
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
        $this->table('emails_marketings')
            ->addColumn('ip', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'origin'
            ])
            ->update();
    }
}
