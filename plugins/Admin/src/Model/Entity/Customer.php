<?php

namespace Admin\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property int $customers_types_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $document
 * @property \Cake\I18n\Time $last_visit
 * @property \Cake\I18n\Time $last_buy
 * @property int $status
 * @property string $telephone
 * @property string $cellphone
 * @property \Cake\I18n\Date $birth_date
 * @property string $gender
 * @property string $company_name
 * @property string $trading_name
 * @property string $company_state
 * @property string $company_document
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Customer extends Entity
{
    protected $_virtual = ['last_visit_format', 'last_buy_format', 'count_total_orders', 'total_orders', 'bling_status', 'birth_date_format'];
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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    /**
     * @param $password
     * @return bool|string
     */
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }

    /**
     * @return string
     */
    protected function _getLastVisitFormat()
    {
        if (!empty($this->_properties['last_visit'])) {
            return $this->_properties['last_visit']->format('d/m/Y H:i');
        }
        return '--';
    }

    /**
     * @return string
     */
    protected function _getLastBuyFormat()
    {
        if (!empty($this->_properties['last_buy'])) {
            return $this->_properties['last_buy']->format('d/m/Y H:i');
        }
        return '--';
    }

    /**
     * @return int
     */
    public function _getCountTotalOrders()
    {
        if (isset($this->_properties['orders'][0])) {
            return count($this->_properties['orders']);
        }
        return 0;
    }

    /**
     * @return string
     */
    public function _getTotalOrders()
    {
        if (isset($this->_properties['orders'][0])) {
            $total = 0;
            foreach ($this->_properties['orders'] as $order) {
                $total = $total + $order->total;
            }
            return 'R$ ' . number_format($total, 2, ",", ".");
        }
        return 'R$ 0,00';
    }

    /**
     * @return null
     */
    protected function _getBlingStatus()
    {
        if (isset($this->_properties['bling_customers'][0]['status']) && !empty($this->_properties['bling_customers'][0]['status'])) {
            return $this->_properties['bling_customers'][0]['status'];
        }
        return 'Não sincronizado';
    }

    /**
     * @param $document
     * @return mixed
     */
    public function _setDocument($document)
    {
        $this->set('document_clean', preg_replace('/\D/', '', $document));
        return $document;
    }

    /**
     * @param $company_document
     * @return mixed
     */
    public function _setCompanyDocument($company_document)
    {
        $this->set('company_document_clean', preg_replace('/\D/', '', $company_document));
        return $company_document;
    }

    /**
     * @return null
     */
    protected function _getBirthDateFormat()
    {
        if (!empty($this->_properties['birth_date'])) {
            return $this->_properties['birth_date']->format("d/m/Y");
        }
        return null;
    }
}