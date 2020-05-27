<?php
use Migrations\AbstractMigration;

class RemoveDirectMails extends AbstractMigration
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
        $this->table('directs_mails')->drop();
        $this->table('directs_mails_customers')->drop();
        $this->table('directs_mails_products')->drop();

        $this->query("DELETE FROM menus WHERE plugin = 'subscriptions'");
    }
}
