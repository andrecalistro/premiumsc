<?php

namespace Admin\View\Cell;

use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Menu Type Cell
 */
class MenuTypeCell extends Cell
{

	/**
	 * List of valid options that can be passed into this
	 * cell's constructor.
	 *
	 * @var array
	 */
	protected $_validCellOptions = [];

	public function category($current = '')
	{
		$Categories = TableRegistry::getTableLocator()->get('Admin.Categories');
		$categories = $Categories->find()
			->where(['status' => 1])
			->toArray();

		$this->set(compact('categories', 'current'));
	}

	public function product($current = '')
	{
		$Products = TableRegistry::getTableLocator()->get('Admin.Products');
		$products = $Products->find()
			->where(['status' => 1])
			->toArray();

		$this->set(compact('products', 'current'));
	}

	public function page($current = '')
	{
		$Pages = TableRegistry::getTableLocator()->get('Admin.Pages');
		$pages = $Pages->find()
			->where(['status' => 1])
			->toArray();

		$this->set(compact('pages', 'current'));
	}

	public function custom($current = '')
	{
		$this->set(compact('current'));
	}
}