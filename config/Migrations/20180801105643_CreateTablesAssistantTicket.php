<?php

use Migrations\AbstractMigration;

class CreateTablesAssistantTicket extends AbstractMigration
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
        $this->table('payments_tickets_returns')
            ->addColumn('file_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('quantity_tickets', 'integer', [
                'default' => null,
                'null' => true
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
            ])
            ->create();

        $this->table('payments_tickets')
            ->addColumn('orders_id', 'integer', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('payment_code', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('ticket_code', 'integer', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('due', 'datetime', [
                'default' => null,
                'null' => true,
                'limit' => null,
            ])
            ->addColumn('payment_date', 'datetime', [
                'default' => null,
                'null' => true,
                'limit' => null,
            ])
            ->addColumn('payments_tickets_returns_id', 'integer', [
                'default' => null,
                'null' => true
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('amount_paid', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
            ])
            ->addColumn('send_file', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
            ])
            ->addColumn('ticket_file', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255
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
            ])
            ->create();
    }
}
