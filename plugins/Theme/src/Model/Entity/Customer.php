<?php

namespace Theme\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Date;
use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
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
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 */
class Customer extends Entity
{
    protected $_virtual = ['last_visit_format', 'last_buy_format', 'birth_date_format'];
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
     * @param $birth_date
     * @return static
     */
    protected function _setBirthDate($birth_date)
    {
        if (strlen($birth_date) > 0) {
            return Date::createFromFormat("d/m/Y", $birth_date, "America/Sao_Paulo");
        }
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
