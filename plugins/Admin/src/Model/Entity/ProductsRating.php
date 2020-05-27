<?php

namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;

/**
 * ProductsRating Entity
 *
 * @property int $id
 * @property int $customers_id
 * @property int|null $orders_id
 * @property int|null $products_id
 * @property int $rating
 * @property string|null $answer
 * @property int $products_ratings_statuses_id
 * @property string $products_name
 * @property string $products_image
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Admin\Model\Entity\Customer $customer
 * @property \Admin\Model\Entity\Order $order
 * @property \Admin\Model\Entity\Product $product
 * @property \Admin\Model\Entity\ProductsRatingsStatus $products_ratings_status
 */
class ProductsRating extends Entity
{
    protected $_virtual = [
        'product_image_link',
        'created_formatted'
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
        'customers_id' => true,
        'orders_id' => true,
        'products_id' => true,
        'rating' => true,
        'answer' => true,
        'products_ratings_statuses_id' => true,
        'products_name' => true,
        'products_image' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'customer' => true,
        'order' => true,
        'product' => true,
        'products_ratings_status' => true
    ];

    /**
     * @return string|null
     */
    protected function _getProductImageLink()
    {
        if (isset($this->_properties['products_image']) && !empty($this->_properties['products_image'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$this->_properties['products_image']}";
            $url = DS . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$this->_properties['products_image']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    protected function _getCreatedFormatted()
    {
        if (isset($this->_properties['created']) && !empty($this->_properties['created'])) {
            return $this->_properties['created']->format('d/m/Y H:i');
        }
        return null;
    }
}
