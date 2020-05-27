<?php

use Migrations\AbstractMigration;

class AddColumnReplyEmailTemplates extends AbstractMigration
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
        $this->table('email_templates')
            ->addColumn('reply_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'from_email'
            ])
            ->addColumn('reply_email', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'after' => 'reply_name'
            ])
            ->save();
    }
}
