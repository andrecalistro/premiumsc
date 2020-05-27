<?php
use Migrations\AbstractMigration;

class CreateShipmentsMethods extends AbstractMigration
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
        $this->table('shipments_methods')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('image', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $date = \Cake\I18n\Time::now('America/Sao_Paulo')->format('Y-m-d H:i:s');

        $this->table('shipments_methods')
            ->insert([
                [
                    'name' => 'PAC',
                    'slug' => 'pac',
                    'image' => null,
                    'created' => $date,
                    'modified' => $date
                ],
                [
                    'name' => 'Sedex',
                    'slug' => 'sedex',
                    'image' => null,
                    'created' => $date,
                    'modified' => $date
                ],
                [
                    'name' => 'Carta Registrada',
                    'slug' => 'carta-registrada',
                    'image' => null,
                    'created' => $date,
                    'modified' => $date
                ]
            ])
            ->save();
    }
}
