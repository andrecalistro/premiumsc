<?php

namespace CheckoutV2\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomersAddress Entity
 *
 * @property int $id
 * @property string $address
 * @property string $zipcode
 * @property string $number
 * @property string $complement
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 * @property string $description
 * @property int $customers_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \CheckoutV2\Model\Entity\Customer $customer
 */
class CustomersAddress extends Entity
{
    protected $_virtual = ['complete_address'];
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
     * @return string
     */
    protected function _getCompleteAddress()
    {
        if (!empty($this->_properties)) {
            return $this->_properties['address'] . ", " . $this->_properties['number'] . " - " . $this->_properties['complement'] . " - " . $this->_properties['city'] . "/" . $this->_properties['state'] . " - " . $this->_properties['zipcode'];
        }
        return null;
    }
}
