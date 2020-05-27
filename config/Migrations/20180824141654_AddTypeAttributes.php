<?php

use Migrations\AbstractMigration;

class AddTypeAttributes extends AbstractMigration
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
        $this->table('attributes')
            ->addColumn('type', 'string', [
                'default' => 'text',
                'null' => true,
                'limit' => 255,
                'after' => 'slug'
            ])
            ->save();
    }
}
