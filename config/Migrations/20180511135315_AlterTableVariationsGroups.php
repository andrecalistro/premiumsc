<?php

use Migrations\AbstractMigration;

class AlterTableVariationsGroups extends AbstractMigration
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
        $table = $this->table('variations_groups');

        $table->addColumn('auxiliary_field_type', 'string', [
            'default' => 'text',
            'null' => true,
            'limit' => 255,
            'after' => 'slug'
        ]);

        $table->update();
    }
}
