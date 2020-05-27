<?php

namespace CheckoutV2\View\Helper;

use Cake\View\Helper;

/**
 * ProductRating helper
 */
class ProductRatingHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $helpers = ['Html'];

    const iconStar = 'Checkout.icon_star.svg';
    const iconStarCompleted = 'Checkout.icon_star_completed.svg';
    const iconUser = 'Checkout.icon_user-silhouette.svg';

    /**
     * @param $productRating
     * @param bool $renderText
     * @param string $iconStar
     * @param string $iconStarCompleted
     * @return string|null
     */
    public function renderStars(
        $productRating,
        $renderText = true,
        $iconStar = self::iconStar,
        $iconStarCompleted = self::iconStarCompleted)
    {
        if (!$productRating) {
            return null;
        }

        $stars = '';
        for ($i = 0; $i < $productRating['rating']; $i++) {
            $stars .= $this->Html->image($iconStarCompleted, ['class' => 'star']);
        }

        for ($i = 0; $i < (5 - $productRating['rating']); $i++) {
            $stars .= $this->Html->image($iconStar, ['class' => 'star']);
        }

        if ($renderText) {
            return sprintf('<div class="stars">%s <p>(%s)</p></div>', $stars, $productRating['ratingText']);
        }

        return sprintf('<div class="stars">%s</div>', $stars);
    }

    /**
     * @param $productRating
     * @param string $title
     * @param string $iconStar
     * @param string $iconStarCompleted
     * @param string $iconUser
     * @return string|null
     */
    public function renderAnswers(
        $productRating,
        $title = 'Avaliações de Consumidores',
        $iconStar = self::iconStar,
        $iconStarCompleted = self::iconStarCompleted,
        $iconUser = self::iconUser)
    {
        if (!$productRating) {
            return null;
        }

        if (\count($productRating['ratings']) === 0) {
            return null;
        }

        $productAnswers = '';
        foreach ($productRating['ratings'] as $productAnswer) {
            $productAnswers .= '<div class="item">';
                $productAnswers .= '<p class="profile-name">';
                    $productAnswers .= $this->Html->image($iconUser, [
                        'alt' => $productAnswer['customer'],
                        'class' => 'icon'
                    ]);
                    $productAnswers .= $productAnswer['customer'];
                $productAnswers .= '</p>';

                $productAnswers .= '<div class="stars">';
                    for ($i = 0; $i < $productAnswer['rating']; $i++) {
                        $productAnswers .= $this->Html->image($iconStarCompleted, ['class' => 'star']);
                    }

                    for ($i = 0; $i < (5 - $productAnswer['rating']); $i++) {
                        $productAnswers .= $this->Html->image($iconStar, ['class' => 'star']);
                    }
                $productAnswers .= '</div>';

                $productAnswers .= '<p class="desc">';
                    $productAnswers .= $productAnswer['answer'];
                $productAnswers .= '</p>';

            $productAnswers .= '</div><hr>';
        }

        $content = '<section id="avaliacao-de-consumidores">';
            $content .= '<div class="container">';
                $content .= '<div class="row">';
                    $content .= '<div class="col-lg-12">';
                        $content .= sprintf('<h3 class="title"> %s </h3>', $title);
                        $content .= $productAnswers;
                    $content .= '</div>';
                $content .= '</div>';
            $content .= '</div>';
        $content .= '</section>';

        return $content;
    }
}
