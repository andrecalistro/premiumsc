<?php
namespace Admin\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Utility\Text;

/**
 * WishList Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int|null $wish_list_statuses_id
 * @property int $customers_id
 * @property \Cake\I18n\Time|null $validate
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 * @property \Cake\I18n\Time|null $deleted
 *
 * @property \Admin\Model\Entity\WishListStatus $wish_list_status
 * @property \Admin\Model\Entity\Customer $customer
 */
class WishList extends Entity
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
        'description' => true,
        'wish_list_statuses_id' => true,
        'customers_id' => true,
        'validate' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'wish_list_status' => true,
        'customer' => true
    ];

    protected $_virtual = ['full_link'];

    /**
     * @return string
     */
    protected function _getFullLink()
    {
        if (empty($this->_properties)) {
            return null;
        }
        $seo_url = Text::slug(strtolower($this->_properties['name']));
        return Router::url("l/{$seo_url}/{$this->_properties['id']}", true);
    }
}
