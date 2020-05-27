<?php

namespace CheckoutV2\Controller\Component;

use Admin\Model\Table\StoresTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * ProductRating component
 */
class ProductRatingComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public static function getRating($productRating)
    {
        /** @var StoresTable $StoresTable */
        $StoresTable = TableRegistry::getTableLocator()->get('Admin.Stores');
        $configRating = $StoresTable->findConfig('product_rating');
        
        if (!isset($configRating->status) || !$configRating->status) {
            return false;
        }

        if (!isset($productRating['products_ratings']) || \count($productRating['products_ratings']) === 0) {
            return [
                'rating' => 0,
                'ratingText' => sprintf('%s %s', 0, 'avaliações'),
                'total' => 0,
                'ratings' => []
            ];
        }

        $rating = 0;
        $total = 0;
        $ratings = [];
        foreach ($productRating['products_ratings'] as $productRating) {
            $total++;
            $rating += $productRating->rating;
            $ratings[] = [
                'rating' => $productRating->rating,
                'customer' => $productRating->customer->name,
                'answer' => $productRating->answer,
                'created' => $productRating->created->format('d/m/Y')
            ];
        }

        $ratingText = $total === 0 || $total > 1 ? 'avaliações' : 'avaliação';

        return [
            'rating' => round($rating / $total, 0),
            'ratingText' => sprintf('%s %s', $total, $ratingText),
            'total' => $total,
            'ratings' => $ratings
        ];
    }
}
