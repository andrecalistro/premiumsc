<?php

namespace Api\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Theme\Model\Table\ProductsTable;

/**
 * Class ProductsController
 * @package Api\Controller
 *
 * @property ProductsTable $Products
 */
class ProductsController extends AppController
{
    public $Products;

    public function initialize()
    {
        parent::initialize();
        $this->Products = TableRegistry::getTableLocator()->get(Configure::read('Theme') . '.Products');
    }

    public function moreDiscount()
    {
        $query = $this->Products->find()
            ->select([
                'Products.id',
                'Products.name',
                'Products.price',
                'Products.price_special',
                'diff' => '(Products.price-Products.price_special)',
                'Products.condition_product',
                'Products.launch_product',
                'Products.description',
                'Products.stock',
                'Products.status'
            ])
            ->where([
                'Products.price >' => 0,
                'Products.price_special >' => 0,
                'Products.status' => 1
            ])
            ->contain([
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                }
            ]);

        if ($this->request->getQuery('limit')) {
            $query->limit($this->request->getQuery('limit'));
        }

        if ($this->request->getQuery('categories_id')) {
            $categories_id = $this->request->getQuery('categories_id');
            $query->matching('Categories', function ($q) use ($categories_id) {
                return $q->where(['Categories.id IN' => $categories_id]);
            });
        }

        if ($this->request->getQuery('order') && $this->request->getQuery('direction')) {
            $query->order(['Products.' . $this->request->getQuery('order') => $this->request->getQuery('direction')]);
        }

        $products = $query->toArray();
        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }

    public function index()
    {
        $query = $this->Products->find()
            ->select([
                'Products.id',
                'Products.name',
                'Products.code',
                'Products.price',
                'Products.price_special',
                'diff' => '(Products.price-Products.price_special)',
                'Products.condition_product',
                'Products.launch_product',
                'Products.description',
                'Products.stock',
                'Products.status'
            ])
            ->where([
                'Products.price >' => 0,
                //'Products.price_special >' => 0,
                'Products.status' => 1
            ])
            ->contain([
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                }
            ]);

        if ($this->request->getQuery('limit')) {
            $query->limit($this->request->getQuery('limit'));
        }

        if ($this->request->getQuery('categories_id')) {
            $categories_id = explode(",", $this->request->getQuery('categories_id'));
            $query->matching('Categories', function ($q) use ($categories_id) {
                return $q->where(['Categories.id IN' => $categories_id]);
            });
        }

        if ($this->request->getQuery('order') && $this->request->getQuery('direction')) {
            $query->order(['Products.' . $this->request->getQuery('order') => $this->request->getQuery('direction')]);
        } else {
            $query->order(['Products.id' => 'desc']);
        }

        if ($this->request->getQuery('code') && $this->request->getQuery('code')) {
            $query->where([
                'UPPER(Products.code) LIKE' => '%' . strtoupper($this->request->getQuery('code')) . '%'
            ]);
        }

        $results = $query->toArray();
        $products = [];
        if ($this->request->getQuery('compact')) {
            foreach ($results as $key => $result) {
                $products[$key] = (object)[
                    'id' => $result->id,
                    'code' => $result->code,
                    'name' => $result->name,
                    'image' => $result->main_image,
                    'link' => $result->full_link
                ];
            }
        } else {
            $products = $results;
        }

        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }
}