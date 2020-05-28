<?php

namespace Theme\Model\Entity;

use Cake\Core\Configure;
use Cake\Network\Session;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\View\Helper\UrlHelper;

/**
 * Product Entity
 *
 * @property int $id
 * @property string $name
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
 * @property string $resume
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \Theme\Model\Entity\Position $position
 * @property \Theme\Model\Entity\Category[] $categories
 */
class Product extends Entity
{

    public $discount;
    public $discount_debit;
    public $payment;
    protected $_virtual = ['thumb_main_image', 'main_image', 'price_format', 'price_special_format', 'old_price', 'full_link', 'link', 'thumb_image_background_link', 'image_background_link', 'condition_name', 'launch_name', 'description_formatted', 'stock_total', 'variations_tree', 'weight_format', 'width_format', 'height_format', 'length_format'];

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

    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);
        $Payments = TableRegistry::get(Configure::read('Theme') . '.Payments');
        $this->payment = $Payments->findConfig('payment');

        if (isset($this->payment->ticket_discount) && is_numeric($this->payment->ticket_discount) && $this->payment->ticket_discount > 0) {
            $this->discount = $this->payment->ticket_discount / 100;
        }

        if (isset($this->payment->debit_discount) && is_numeric($this->payment->debit_discount) && $this->payment->debit_discount > 0) {
            $this->discount_debit = $this->payment->debit_discount / 100;
        }
    }

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
        return Router::url(DS . "img" . DS . "thumb-no-image.png", true);
    }

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
        return Router::url(DS . "img" . DS . "no-image.png", true);
    }

    /**
     * @return null|string
     */
    protected function _getPriceFormat()
    {
        if (isset($this->_properties['price']) && !empty($this->_properties['price'])) {
            if (isset($this->_properties['price_special']) && !empty($this->_properties['price_special'])) {
                $price = $this->_properties['price_special'];
                $installments = $this->installments($this->_properties['price_special']);
                $discount = $this->_properties['price_special'] - ($this->discount * $this->_properties['price_special']);
                $discount_debit = $this->_properties['price_special'] - ($this->discount_debit * $this->_properties['price_special']);
            } else {
                $price = $this->_properties['price'];
                $installments = $this->installments($price);
                $discount = $price - ($this->discount * $price);
                $discount_debit = $price - ($this->discount_debit * $price);
            }
            return [
                'formatted' => "R$ " . number_format($price, 2, ",", "."),
                'regular' => $price,
                'discount' => $discount,
                'discount_formatted' => 'R$ ' . number_format($discount, 2, ",", "."),
                'discount_text' => '',
                'discount_debit' => $discount_debit,
                'discount_debit_formatted' => 'R$ ' . number_format($discount_debit, 2, ",", "."),
                'discount_debit_text' => '',
                'installments' => $installments['installments'],
                'installment' => $installments['last']
            ];

        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getPriceSpecialFormat()
    {
        if (isset($this->_properties['price_special']) && !empty($this->_properties['price_special'])) {
            return "R$ " . number_format($this->_properties['price_special'], 2, ",", ".");
        }
        return null;
    }

    /**
     * @return null|string
     */
    protected function _getOldPrice()
    {
        if (isset($this->_properties['price_special']) && !empty($this->_properties['price_special'])) {
            if (isset($this->_properties['price']) && !empty($this->_properties['price'])) {
                return "R$ " . number_format($this->_properties['price'], 2, ",", ".");
            }
        }
        return null;
    }

    /**
     * return link with base url to product
     *
     * @return string
     */
    protected function _getFullLink()
    {
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            $seo_url = Text::slug(strtolower($this->_properties['name']));
        }
        return Router::url("produto/{$seo_url}/{$this->_properties['id']}", true);
    }

    /**
     * return link without base url to product
     *
     * @return string
     */
    protected function _getLink()
    {
        if (isset($this->_properties['seo_url']) && !empty($this->_properties['seo_url'])) {
            $seo_url = $this->_properties['seo_url'];
        } else {
            $seo_url = Text::slug(strtolower($this->_properties['name']));
        }
        return Router::url("produto/{$seo_url}/{$this->_properties['id']}");
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
        if ($this->_properties['condition_product']) {
            return 'Produto seminovo';
        }
        return false;
    }

    /**
     * @return bool|string
     */
    protected function _getLaunchName()
    {
        if ($this->_properties['launch_product']) {
            return 'Lançamento';
        }
        return false;
    }

    protected function _getDescriptionFormatted()
    {
        $description = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $this->_properties['description']);
        return preg_replace('/(<font[^>]*>)|(<\/font>)/', '', $description);
    }

    /**
     * @param $price
     * @return array
     */
    protected function installments($price)
    {
        $installments = [
            'installments' => false,
            'last' => false
        ];
        $interest = str_replace(',', '.', $this->payment->interest) / 100;
        $installment_max = $this->payment->installment > 0 ? $this->payment->installment : 1;
        for ($i = 1; $i <= $installment_max; $i++) {
            if ($i <= $this->payment->installment_free) {
                $price_without_installment = ($price / $i);
                if ($price_without_installment >= $this->payment->installment_min) {
                    $installments['installments'][] = [
                        'installment' => $i,
                        'price' => $price_without_installment,
                        'price_formatted' => 'R$ ' . number_format($price_without_installment, 2, ",", "."),
                        'text' => 'sem juros',
                        'complete' => $i . 'x de R$ ' . number_format($price_without_installment, 2, ",", ".") . ' sem juros'
                    ];
                    if ($this->payment->installment_free > 1) {
                        $installments['last'] = [
                            'installment' => $i,
                            'price' => $price_without_installment,
                            'price_formatted' => 'R$ ' . number_format($price_without_installment, 2, ",", "."),
                            'text' => 'sem juros',
                            'complete' => $i . 'x de R$ ' . number_format($price_without_installment, 2, ",", ".") . ' sem juros'
                        ];
                    }
                }
            } else {
                $price_with_installment = $price / ((1 - pow((1 - $interest), $i)) / $interest);
                if ($price_with_installment >= $this->payment->installment_min) {
                    $installments['installments'][] = [
                        'installment' => $i,
                        'price' => $price_with_installment,
                        'price_formatted' => 'R$ ' . number_format($price_with_installment, 2, ",", "."),
                        'text' => 'com juros',
                        'complete' => $i . 'x de R$ ' . number_format($price_with_installment, 2, ",", ".") . ' com juros'
                    ];
                    if ($this->payment->installment_free < 2) {
                        $installments['last'] = [
                            'installment' => $i,
                            'price' => $price_with_installment,
                            'price_formatted' => 'R$ ' . number_format($price_with_installment, 2, ",", "."),
                            'text' => 'com juros',
                            'complete' => $i . 'x de R$ ' . number_format($price_with_installment, 2, ",", ".") . ' com juros'
                        ];
                    }
                }
            }
        }
        return $installments;
    }

    /**
     * @return int
     */
    protected function _getStockTotal()
    {
        if (isset($this->_properties['products_variations']) && !empty($this->_properties['products_variations'])) {
            $stock = 0;
            foreach ($this->_properties['products_variations'] as $variation) {
                $stock += $variation->stock;
            }
            $this->_properties['stock'] = $stock;
            return $stock;
        }
        return $this->_properties['stock'];
    }

    /**
     * @return array|bool
     */
    protected function _getVariationsTree()
    {
        if (isset($this->_properties['products_variations']) && !empty($this->_properties['products_variations'])) {
            $variations_groups = Hash::combine(Hash::extract($this->_properties, 'products_variations.{n}.variations_group'), '{n}.id', '{n}');
            $variations_groups = Hash::insert($variations_groups, '{n}.variations', false);
            foreach ($this->_properties['products_variations'] as $variation) {
                if ($variation->stock > 0) {
                    $variations_groups[$variation->variations_groups_id]['variations'][] = [
                        'products_variations_id' => $variation->id,
                        'stock' => $variation->stock,
                        'image_link' => $variation->image_link,
                        'thumb_image_link' => $variation->thumb_image_link,
                        'auxiliary_field' => $variation->auxiliary_field,
                        'variation' => $variation->variation
                    ];
                }
            }
            $variations_groups = Hash::remove($variations_groups, '{n}[variations=false]');
            return $variations_groups;
        }
        return false;
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
}
