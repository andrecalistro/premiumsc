<?php
use Migrations\AbstractMigration;

class InsertDueDaysOrders extends AbstractMigration
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
        $this->table('stores')
            ->insert([
                [
                    'code' => 'store',
                    'keyword' => 'store_due_days',
                    'value' => 10,
                    'created' => \Cake\I18n\Time::now('America/Sao_Paulo')->format('Y-m-d H:i:s'),
                    'modified' => \Cake\I18n\Time::now('America/Sao_Paulo')->format('Y-m-d H:i:s')
                ]
            ])
            ->save();
    }
}
