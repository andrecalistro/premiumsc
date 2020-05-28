<?php
namespace Theme\View\Cell;

use Admin\Model\Table\StoresMenusItemsTable;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Class MenuCell
 * @package Theme\View\Cell
 */
class MenuCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     *
     */
    public function menuHeader()
    {
        $menus = $this->getMenus('menu-principal');

        $this->set(compact('menus'));
    }

    /**
     *
     */
    public function menuHeaderMobile()
    {
        $menus = $this->getMenus('menu-principal');

        $this->set(compact('menus'));
    }

    /**
     * @param $title
     * @param $slug
     */
    public function menuFooter($title, $slug)
    {
        $menus = $this->getMenus($slug);

        $this->set(compact('menus', 'title'));
    }

    /**
     *
     */
    public function menuMinhaArea()
    {
        $menus = $this->getMenus('menu-minha-area-footer');

        $this->set(compact('menus'));
    }

    /**
     *
     */
    public function menuContato()
    {
        $menus = $this->getMenus('menu-contato');

        $this->set(compact('menus'));
    }


    /**
     * @param $slug
     * @return array
     */
    private function getMenus($slug)
    {
        /** @var StoresMenusItemsTable  $StoresMenusItemsTable */
        $StoresMenusItemsTable = TableRegistry::getTableLocator()->get('Admin.StoresMenusItems');

        return $StoresMenusItemsTable->find('threaded')
            ->where([
                'StoresMenusItems.status' => 1
            ])
            ->matching('StoresMenusGroups', function (Query $q) use ($slug) {
                return $q->where(['StoresMenusGroups.slug' => $slug]);
            })
            ->order([
                'StoresMenusItems.position' => 'ASC',
                'StoresMenusItems.name' => 'ASC'
            ])
            ->toArray();
    }
}
