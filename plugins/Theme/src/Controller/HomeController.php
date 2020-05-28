<?php

namespace Theme\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
    }

    /**
     *
     */
    public function index()
    {
        $Categories = TableRegistry::get(Configure::read("Theme").'.Categories');
		$Products = TableRegistry::get(Configure::read("Theme").'.Products');

        $categories = $Categories->find()
			->contain(['ChildCategories'])
			->where(['show_launch_menu' => 1, 'parent_id IS NULL'])
			->toArray();

		foreach ($categories as $key => $category) {
			$categories_ids = [$category->id];

			if ($category->list_categories_child) {
				$categories_ids = array_merge($categories_ids, $category->list_categories_child);
			}

			$products = $Products->find()
				->contain([
					'ProductsImages' => function ($q) {
						return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
					},
				])
				->matching('Categories', function ($q) use ($categories_ids) {
					return $q->where(['Categories.id IN' => $categories_ids]);
				})
				->toArray();

			$categories[$key]->products = $products;
        }

        $this->set(compact('categories'));
    }
}