<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * PaymentsTicket Entity
 *
 * @property int $id
 * @property int $orders_id
 * @property string $payment_code
 * @property int $ticket_code
 * @property \Cake\I18n\FrozenTime $due
 * @property \Cake\I18n\FrozenTime $payment_date
 * @property int $payments_tickets_sends_id
 * @property float $amount
 * @property float $amount_paid
 * @property string $return_file
 * @property string $ticket_file
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 *
 * @property \Admin\Model\Entity\Order $order
 */
class PaymentsTicket extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public $_virtual = [
        'amount_format',
        'amount_paid_format',
        'return_link',
        'ticket_link'
    ];

    /**
     * @return null|string
     */
    protected function _getAmountFormat()
    {
        if (isset($this->_properties['amount']) && !empty($this->_properties['amount'])) {
            return "R$ " . number_format($this->_properties['amount'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getAmountPaidFormat()
    {
        if (isset($this->_properties['amount_paid']) && !empty($this->_properties['amount_paid'])) {
            return "R$ " . number_format($this->_properties['amount_paid'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getReturnLink()
    {
        if (isset($this->_properties['return_file']) && !empty($this->_properties['return_file'])) {
            return Router::url($this->_properties['return_file'], true);
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getTicketLink()
    {
        if (isset($this->_properties['ticket_file']) && !empty($this->_properties['ticket_file'])) {
            return Router::url($this->_properties['ticket_file'], true);
        }
        return null;
    }
}
