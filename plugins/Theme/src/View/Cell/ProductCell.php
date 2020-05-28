<?php
namespace Theme\View\Cell;

use Admin\Model\Entity\Position;
use Admin\Model\Table\PositionsTable;
use Theme\Model\Table\ProductsPositionsTable;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Class ProductCell
 * @package Theme\View\Cell
 */
class ProductCell extends Cell
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
    public function home()
    {
        /** @var PositionsTable $positionsTable */
        $positionsTable = TableRegistry::getTableLocator()->get('Admin.Positions');

        $positions = [];

        $positionsResult = $positionsTable->find()
            ->toArray();

        /** @var Position $position */
        foreach($positionsResult as $position) {
            $products = $this->getProducts($position->slug);
            if(!$products){
                continue;
            }
            $positions[] = [
                'title' => $position->name,
                'slug' => $position->slug,
                'products' => $products
            ];
        }

        $this->set(compact('positions'));
    }

    /**
     * @param $slug
     * @return array
     */
    private function getProducts($slug)
    {
        /** @var ProductsPositionsTable  $ProductsPositionsTable */
        $ProductsPositionsTable = TableRegistry::getTableLocator()->get('Theme.ProductsPositions');

        return $ProductsPositionsTable->find()
            ->matching('Positions', function (Query $q) use ($slug) {
                return $q->where(['Positions.slug' => $slug]);
            })
            ->contain([
                'Products' => function (Query $q) {
                    return $q->contain([
                        'ProductsImages' => function (Query $q) {
                            return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                        },
                    ]);
                }
            ])
            ->order([
                'ProductsPositions.order_show' => 'ASC'
            ])
            ->toArray();
    }
}
