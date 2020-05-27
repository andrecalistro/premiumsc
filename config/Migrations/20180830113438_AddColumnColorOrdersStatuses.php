<?php

use Migrations\AbstractMigration;

class AddColumnColorOrdersStatuses extends AbstractMigration
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
        $table = $this->table('orders_statuses')
            ->addColumn('background_color', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'slug'
            ])
            ->addColumn('font_color', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'background_color'
            ]);

        $table->save();
        $table->truncate();
        $date = \Cake\I18n\Time::now('America/Sao_Paulo')->format('Y-m-d H:i:s');
        $table->insert([
            [
                'id' => 1,
                'name' => 'Aguardando Pagamento',
                'slug' => 'aguardando-pagamento',
                'background_color' => '#f0ad4e',
                'font_color' => '#ffffff',
                'created' => $date,
                'modified' => $date
            ],
            [
                'id' => 2,
                'name' => 'Pagamento Aprovado',
                'slug' => 'pagamento-aprovado',
                'background_color' => '#5bc0de',
                'font_color' => '#ffffff',
                'created' => $date,
                'modified' => $date
            ],
            [
                'id' => 3,
                'name' => 'Preparando para Envio',
                'slug' => 'preparando-para-envio',
                'background_color' => '#5bc0de',
                'font_color' => '#ffffff',
                'created' => $date,
                'modified' => $date
            ],
            [
                'id' => 4,
                'name' => 'Pedido Enviado',
                'slug' => 'pedido-enviado',
                'background_color' => '#5bc0de',
                'font_color' => '#ffffff',
                'created' => $date,
                'modified' => $date
            ],
            [
                'id' => 5,
                'name' => 'Entrega Realizada',
                'slug' => 'entrega-realizada',
                'background_color' => '#449d44',
                'font_color' => '#ffffff',
                'created' => $date,
                'modified' => $date
            ],
            [
                'id' => 6,
                'name' => 'Cancelado',
                'slug' => 'cancelado',
                'background_color' => '#d9534f',
                'font_color' => '#ffffff',
                'created' => $date,
                'modified' => $date
            ],
        ])
            ->save();
    }
}
