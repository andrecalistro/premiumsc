<?php

namespace Theme\View\Cell;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Theme\Model\Table\CategoriesTable;

/**
 * Class CollectionCell
 * @package Theme\View\Cell
 */
class CollectionCell extends Cell
{
    /**
     *
     */
    public function get()
    {
        /** @var CategoriesTable $categoriesTable */
        $categoriesTable = TableRegistry::getTableLocator()->get('Theme.Categories');

        $categories = $categoriesTable->find()
            ->where([
                'Categories.status' => 1
            ])
            ->matching('ParentCategories', function (Query $q) {
                return $q->where([
                    'ParentCategories.slug' => 'colecoes'
                ]);
            })
            ->order(['Categories.order_show' => 'ASC'])
            ->toArray();

        $this->set(compact('categories'));
    }
}
