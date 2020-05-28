<?php
namespace Theme\View\Helper;

use Cake\View\Helper;

/**
 * @property \Cake\View\Helper\FormHelper $Form
 *
 * Custom helper
 */
class CustomHelper extends Helper\PaginatorHelper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $helpers = ['Form'];

    public function paginationLimit(array $limits = [], array $options = [], $default = null)
    {
        $out = $this->Form->create(null, ['type' => 'get']);
        if (empty($default) || !is_numeric($default)) {
            $default = $this->param('perPage');
        }

        if (empty($limits)) {
            $limits = [
                '20' => '20',
                '50' => '50',
                '100' => '100'
            ];
        }
        $out .= $this->Form->control('limit', $options + [
                'type' => 'select',
                'label' => __('View'),
                'value' => $default,
                'options' => $limits,
                'onChange' => 'paginatorLimit($(this))'
            ]);
        $out .= $this->Form->end();
        return $out;
    }

    public function convertMedia($url = '', $width = 420, $height = 345)
    {
        $html = '';
        $pattern1 = '/(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/';
        $pattern2 = '/(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/';
        $pattern3 = '/([-a-zA-Z0-9@:%_\+.~#?&]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&]*)?(?:jpg|jpeg|gif|png))/';

        if (preg_match($pattern1, $url)) {
            $replacement = '<iframe width="' . $width . '" height="' . $height . '" src="//player.vimeo.com/video/$1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
            $html = preg_replace($pattern1, $replacement, $url);
        }


        if (preg_match($pattern2, $url)) {
            $replacement = '<iframe width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';
            $html = preg_replace($pattern2, $replacement, $url);
        }


        if (preg_match($pattern3, $url)) {
            $replacement = '<a href="$1" target="_blank"><img class="sml" src="$1" /></a><br />';
            $html = preg_replace($pattern3, $replacement, $url);
        }

        return $html;
    }

}
