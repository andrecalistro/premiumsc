<?php

namespace Theme\Controller;

/**
 * Filters Controller
 *
 * @property \Theme\Model\Table\FiltersTable $Filters
 *
 * @method \Theme\Model\Entity\Filter[] paginate($object = null, array $settings = [])
 */
class FiltersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow();
    }

    /**
     * @param null $filters_id
     */
    public function view($filters_id = null)
    {
        $filter = $this->Filters->get($filters_id, [
            'contain' => ['FiltersGroups' => function ($q) {
                return $q->select(['name']);
            }]
        ]);

        $this->set('_description', $filter->seo_description);

        $products = $this->paginate($this->Filters->Products->find()
            ->contain(['ProductsImages'])
            ->matching('Filters', function ($q) use ($filters_id) {
                return $q->where(['Filters.id' => $filters_id]);
            })
        );

        $this->pageTitle = $filter->name;
        $this->set(compact('filter', 'products'));
        $this->set('_serialize', ['products']);
    }
}
