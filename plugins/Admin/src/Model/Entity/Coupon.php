<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $code
 * @property string $type
 * @property float $value
 * @property bool $free_shipping
 * @property \Cake\I18n\FrozenTime $release_date
 * @property \Cake\I18n\FrozenTime $expiration_date
 * @property float $min_value
 * @property float $max_value
 * @property bool $only_individual_use
 * @property bool $exclude_promotional_items
 * @property string $products_ids
 * @property string $excluded_products_ids
 * @property string $categories_ids
 * @property string $excluded_categories_ids
 * @property string $restricted_emails_list
 * @property int $use_limit
 * @property int $used_limit
 * @property int $customer_use_limit
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $deleted
 */
class Coupon extends Entity
{
    protected $_virtual = [
        'value_formatted',
        'min_value_formatted',
        'max_value_formatted',
        'products_ids_array',
        'excluded_products_ids_array',
        'categories_ids_array',
        'excluded_categories_ids_array',
        'restricted_emails_list_array',
        'formatted_deadlines'
    ];

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
     * @return null|string
     */
    protected function _getValueFormatted()
    {
        if (!empty($this->_properties['value'])) {
            return number_format($this->_properties['value'], 2, ',', '.');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getMinValueFormatted()
    {
        if (!empty($this->_properties['min_value'])) {
            return number_format($this->_properties['min_value'], 2, ',', '.');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getMaxValueFormatted()
    {
        if (!empty($this->_properties['max_value'])) {
            return number_format($this->_properties['max_value'], 2, ',', '.');
        }
        return null;
    }

    /**
     * @return array|mixed|object
     */
    protected function _getProductsIdsArray()
    {
        if (!isset($this->_properties['products_ids'])) {
            return null;
        }
        return json_decode($this->_properties['products_ids'], true);
    }

    /**
     * @return array|mixed|object
     */
    protected function _getExcludedProductsIdsArray()
    {
        if (!isset($this->_properties['excluded_products_ids'])) {
            return null;
        }
        return json_decode($this->_properties['excluded_products_ids'], true);
    }

    /**
     * @return array|mixed|object
     */
    protected function _getCategoriesIdsArray()
    {
        if (!isset($this->_properties['categories_ids'])) {
            return null;
        }
        return json_decode($this->_properties['categories_ids'], true);
    }

    /**
     * @return array|mixed|object
     */
    protected function _getExcludedCategoriesIdsArray()
    {
        if (!isset($this->_properties['excluded_categories_ids'])) {
            return null;
        }
        return json_decode($this->_properties['excluded_categories_ids'], true);
    }

    /**
     * @return array
     */
    protected function _getRestrictedEmailsListArray()
    {
        if (!isset($this->_properties['restricted_emails_list'])) {
            return null;
        }
        $email_list = explode(PHP_EOL, $this->_properties['restricted_emails_list']);
        foreach ($email_list as $key => $email) {
            $email_list[$key] = trim($email);
        }

        return $email_list;
    }

    /**
     * @return array
     */
    public function _getFormattedDeadlines()
    {
        $release_date = $expiration_date = '';

        if (!empty($this->_properties['release_date'])) {
            $release_date = $this->_properties['release_date']->format('d/m/Y H:i');
        }

        if (!empty($this->_properties['expiration_date'])) {
            $expiration_date = $this->_properties['expiration_date']->format('d/m/Y H:i');
        }

        return [
            'release_date' => $release_date,
            'expiration_date' => $expiration_date
        ];
    }

    /**
     * @param $code
     * @return mixed
     */
    protected function _setCode($code)
    {
        if ($code) {
            return strtoupper($code);
        }
        return null;
    }
}
