<?php

use Migrations\AbstractMigration;

class AlterTableOrderAddCoupon extends AbstractMigration
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
        $table = $this->table('orders');

        $table->addColumn('coupons_id', 'integer', [
            'default' => null,
            'null' => true,
            'after' => 'orders_types_id'
        ])
            ->addColumn('coupon_discount', 'decimal', [
                'default' => null,
                'null' => true,
                'precision' => 15,
                'scale' => 2,
                'after' => 'coupons_id'
            ]);

        $table->update();
    }
}
