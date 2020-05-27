<?php

namespace Subscriptions\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * Plan Entity
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $frequency_delivery_id
 * @property int|null $frequency_billing_id
 * @property int $status
 * @property \Cake\I18n\Date $due_at
 * @property float|null $price
 * @property string|null $description
 * @property float|null $weight
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 * @property int|null $shipping_required
 * @property int|null $shipping_free
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_url
 * @property string|null $seo_image
 * @property string|null pagseguro_reference
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property string|null $full_link
 * @property string|null $link
 * @property string|null $thumb_main_image
 * @property string|null $main_image
 * @property string|null $price_format
 * @property string|null $weight_format
 * @property string|null $width_format
 * @property string|null $height_format
 * @property string|null $length_format
 * @property array $dimensions
 *
 * @property \Subscriptions\Model\Entity\PlanDeliveryFrequency $plan_delivery_frequency
 * @property \Subscriptions\Model\Entity\PlanBillingFrequency $plan_billing_frequency
 * @property PlansImage $plans_images
 */
class Plan extends Entity
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
        'name' => true,
        'frequency_delivery_id' => true,
        'frequency_billing_id' => true,
        'status' => true,
        'due_at' => true,
        'price' => true,
        'description' => true,
        'weight' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'shipping_required' => true,
        'shipping_free' => true,
        'seo_title' => true,
        'seo_description' => true,
        'seo_url' => true,
        'seo_image' => true,
        'pagseguro_reference' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'plan_delivery_frequency' => true,
        'plan_billing_frequency' => true
    ];

    public $_virtual = [
        'price_format',
        'status_name',
        'main_image',
        'thumb_main_image',
        'weight_format',
        'width_format',
        'height_format',
        'length_format',
        'full_link',
        'link',
        'dimensions'
    ];

    /**
     * @return null|string
     */
    protected function _getPriceFormat()
    {
        if (isset($this->_properties['price']) && !empty($this->_properties['price'])) {
            return "R$ " . number_format($this->_properties['price'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return string
     */
    protected function _getStatusName()
    {
        if (!isset($this->_properties['status'])) {
            return null;
        }
        return $this->_properties['status'] ? 'Ativo' : 'Inativo';
    }

    /**
     * @return null|string
     */
    protected function _getThumbMainImage()
    {
        if (isset($this->_properties['plans_images'][0])) {
            $image = 'thumbnail-' . $this->_properties['plans_images'][0]->image;
            $path = WWW_ROOT . "img" . DS . "files" . DS . "PlansImages" . DS . "{$image}";
            $url = DS . "img" . DS . "files" . DS . "PlansImages" . DS . "{$image}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getMainImage()
    {
        if (isset($this->_properties['plans_images'][0])) {
            $image = $this->_properties['plans_images'][0]->image;
            $path = WWW_ROOT . "img" . DS . "files" . DS . "PlansImages" . DS . "{$image}";
            $url = DS . "img" . DS . "files" . DS . "PlansImages" . DS . "{$image}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getWeightFormat()
    {
        if (!empty($this->_properties['weight'])) {
            return number_format($this->_properties['weight'], 3, ',', '');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getWidthFormat()
    {
        if (!empty($this->_properties['width'])) {
            return number_format($this->_properties['width'], 2, ',', '');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getHeightFormat()
    {
        if (!empty($this->_properties['height'])) {
            return number_format($this->_properties['height'], 2, ',', '');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getLengthFormat()
    {
        if (!empty($this->_properties['length'])) {
            return number_format($this->_properties['length'], 2, ',', '');
        }
        return null;
    }

    /**
     * @return string
     */
    protected function _getFullLink()
    {
        if (!isset($this->_properties['seo_url'])) {
            return null;
        }
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            $seo_url = Text::slug(strtolower($this->_properties['name']));
        }
        return Router::url("plano/{$seo_url}/{$this->_properties['id']}", true);
    }

    /**
     * return link without base url to product
     *
     * @return string
     */
    protected function _getLink()
    {
        if (!isset($this->_properties['seo_url'])) {
            return null;
        }
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            $seo_url = Text::slug(strtolower($this->_properties['name']));
        }
        return Router::url("plano/{$seo_url}/{$this->_properties['id']}");
    }

    /**
     * @return array
     */
    protected function _getDimensions()
    {
        if (!isset($this->_properties['id'])) {
            return null;
        }
        return [
            'name' => $this->_properties['name'],
            'quantity' => 1,
            'weight' => $this->_properties['weight'],
            'length' => $this->_properties['length'],
            'width' => $this->_properties['width'],
            'height' => $this->_properties['height'],
            'total_price' => $this->_properties['price']
        ];
    }
}
