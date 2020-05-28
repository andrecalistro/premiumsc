<?php

namespace Theme\View\Cell;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;
use Theme\Model\Table\BannersImagesTable;

/**
 * Banner cell
 *
 * @property \Theme\Model\Table\BannersTable $Banners
 */
class BannerCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * @param $slug
     * @param null $limit
     */
    public function display($slug, $limit = null)
    {
        $images = $this->getBanners($slug, $limit);
        $this->viewBuilder()->setTemplate($slug);
        $this->set(compact('images'));
    }

    /**
     * @param $slug
     * @param null $limit
     * @return array
     */
    private function getBanners($slug, $limit = null)
    {
        /** @var BannersImagesTable $BannersImagesTable */
        $BannersImagesTable = TableRegistry::getTableLocator()->get('Theme.BannersImages');

        $query = $BannersImagesTable->find()
            ->where([
                'BannersImages.status' => 1
            ])
            ->matching('Banners', function (Query $q) use ($slug) {
                return $q->where([
                    'Banners.slug' => $slug
                ]);
            });

        if ($limit) {
            $query->limit($limit);
        }

        return $query->toArray();
    }
}
