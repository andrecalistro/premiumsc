<?php

namespace Admin\Model\Entity;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Text;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $code
 * @property string $ean
 * @property string $name
 * @property int $categories_id
 * @property string $tags
 * @property int $stock
 * @property float $price
 * @property float $price_special
 * @property int $stock_control
 * @property int $show_price
 * @property string $description
 * @property float $weight
 * @property float $length
 * @property float $width
 * @property float $height
 * @property int $shipping_free
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_url
 * @property int $main
 * @property int $positions_id
 * @property string $image_background
 * @property int $condition_product
 * @property int $launch_product
 * @property string $video
 * @property int $products_id
 * @property string $resume
 * @property int $status
 * @property int $providers_id
 * @property int $providers_payment_status
 * @property int $stock_total
 * @property \Cake\I18n\Time $expiration_date
 * @property \Cake\I18n\Time $release_date
 * @property int $additional_delivery_time
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Admin\Model\Entity\Category[] $categories
 * @property \Admin\Model\Entity\Banner $banner
 */
class Product extends Entity
{
    protected $_virtual = ['thumb_main_image', 'main_image', 'price_format', 'price_special_format', 'price_final', 'weight_format', 'width_format', 'height_format', 'length_format', 'thumb_image_background_link', 'image_background_link', 'condition_name', 'launch_name', 'status_name', 'price_promotional', 'provider_name', 'filters_names', 'bling_status', 'full_link', 'stock_total', 'formatted_deadlines', 'stock_available_options'];
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
    protected function _getThumbMainImage()
    {
        if (isset($this->_properties['products_images'][0])) {
            $image = 'thumbnail-' . $this->_properties['products_images'][0]->image;
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$image}";
            $url = DS . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$image}";
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
        if (isset($this->_properties['products_images'][0])) {
            $image = $this->_properties['products_images'][0]->image;
            $path = WWW_ROOT . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$image}";
            $url = DS . "img" . DS . "files" . DS . "ProductsImages" . DS . "{$image}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getPriceFormat()
    {
        if (!empty($this->_properties['price'])) {
            return number_format($this->_properties['price'], 2, ',', '.');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getPriceSpecialFormat()
    {
        if (!empty($this->_properties['price_special'])) {
            return number_format($this->_properties['price_special'], 2, ',', '.');
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getPricePromotionalFormat()
    {
        if (!empty($this->_properties['price_promotional'])) {
            return number_format($this->_properties['price_promotional'], 2, ',', '.');
        }
        return null;
    }

    /**
     * @return array|null
     */
    protected function _getPriceFinal()
    {
        $price = 0;

        if (!empty($this->_properties['price_special'])) {
            $price = $this->_properties['price_special'];
        } else if (!empty($this->_properties['price'])) {
            $price = $this->_properties['price'];
        }

        return [
            'regular' => $price,
            'formatted' => 'R$ ' . number_format($price, 2, ',', '.')
        ];
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
     * @return null|string
     */
    protected function _getImageBackgroundLink()
    {
        if (!empty($this->_properties['image_background'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Products" . DS . "{$this->_properties['image_background']}";
            $url = DS . "img" . DS . "files" . DS . "Products" . DS . "{$this->_properties['image_background']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getThumbImageBackgroundLink()
    {
        if (!empty($this->_properties['image_background'])) {
            $path = WWW_ROOT . "img" . DS . "files" . DS . "Products" . DS . "thumbnail-{$this->_properties['image_background']}";
            $url = DS . "img" . DS . "files" . DS . "Products" . DS . "thumbnail-{$this->_properties['image_background']}";
            if (is_file($path) && file_exists($path)) {
                return Router::url($url, true);
            }
        }
        return null;
    }

    /**
     * @return bool|string
     */
    protected function _getConditionName()
    {
        if (!isset($this->_properties['condition_product'])) {
            return null;
        }

        if ($this->_properties['condition_product']) {
            return 'Usado';
        }

        return 'Novo';
    }

    /**
     * @return bool|string
     */
    protected function _getLaunchName()
    {
        if (!isset($this->_properties['launch_product'])) {
            return null;
        }

        if ($this->_properties['launch_product']) {
            return 'Lançamento';
        }

        return false;
    }

    /**
     * @return string
     */
    protected function _getStatusName()
    {
        if (!isset($this->_properties['status'])) {
            return null;
        }

        if ($this->_properties['status']) {
            return 'Habilitado';
        }

        return 'Desabilitado';
    }

    /**
     * @return null
     */
    protected function _getProviderName()
    {
        if (!isset($this->_properties['provider']['name'])) {
            return null;
        }

        if (isset($this->_properties['provider']['name'])) {
            return $this->_properties['provider']['name'];
        }

        return null;
    }

    /**
     * @return array|null
     */
    protected function _getFiltersArray()
    {
        if (isset($this->_properties['filters']) && !empty($this->_properties['filters'])) {
            return Hash::extract($this->_properties['filters'], '{n}.id');
        }
        return [];
    }

    /**
     * @return array
     */
    protected function _getFiltersNames()
    {
        $filters = ['marca' => ['first' => null, 'all' => []], 'cor' => ['first' => null, 'all' => []], 'tamanho' => ['first' => null, 'all' => []]];
        if (isset($this->_properties['filters']) && !empty($this->_properties['filters'])) {
            foreach ($this->_properties['filters'] as $filter) {
                if ($filter->filters_group) {
                    !isset($filters[$filter->filters_group->slug]['first']) && empty($filters[$filter->filters_group->slug]['first']) ? $filters[$filter->filters_group->slug]['first'] = $filter->name : '';
                    $filters[$filter->filters_group->slug]['all'][] = $filter->name;
                }
            }
        }
        return $filters;
    }

    /**
     * @return null
     */
    protected function _getBlingStatus()
    {
        if (isset($this->_properties['bling_products'][0]['status']) && !empty($this->_properties['bling_products'][0]['status'])) {
            return $this->_properties['bling_products'][0]['status'];
        }
        return 'Não sincronizado';
    }

    /**
     * @return string
     */
    protected function _getFullLink()
    {
        if (empty($this->_properties)) {
            return null;
        }
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            $seo_url = Text::slug(strtolower($this->_properties['name']));
        }
        return Router::url("produto/{$seo_url}/{$this->_properties['id']}", true);
    }

    /**
     * @return int
     */
    protected function _getStockTotal()
    {
        if (empty($this->_properties) || !isset($this->_properties['stock'])) {
            return null;
        }

        if (isset($this->_properties['products_variations']) && $this->_properties['products_variations']) {
            $stock = 0;
            foreach ($this->_properties['products_variations'] as $variation) {
                $stock += $variation->stock;
            }
            return $stock;
        }
        return $this->_properties['stock'];
    }

    /**
     * @return bool
     */
    public function _getFormattedDeadlines()
    {
        if (empty($this->_properties)) {
            return null;
        }

        if (!empty($this->_properties['expiration_date'])) {
            $this->_properties['expiration_date'] = $this->_properties['expiration_date']->format('d/m/Y H:i');
        }
        if (!empty($this->_properties['release_date'])) {
            $this->_properties['release_date'] = $this->_properties['release_date']->format('d/m/Y H:i');
        }
        return true;
    }

    /**
     * @return array
     */
    public function _getStockAvailableOptions()
    {
        if (empty($this->_properties) || !isset($this->_properties['stock_control'])) {
            return null;
        }

        if ($this->_properties['stock_control'] && $this->_properties["stock"] <= 50) {
            return range(1, $this->_properties['stock']);
        }
        return range(1, 50);
    }

    

    /**
     * @return string
     */
    protected function _getViewLink()
    {
        if (empty($this->_properties)) {
            return null;
        }
        return Router::url('/produto/' . $this->_properties['seo_url'] . '/' . $this->_properties['id'], true);
    }
}
