<?php

namespace Admin\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Custom helper
 *
 * @property Helper\PaginatorHelper $Paginator
 */
class CustomHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $helpers = ['Paginator'];

    public function selectPages($options)
    {
        $style = '';
        if (isset($options['style'])) {
            $style = 'style="' . $options['style'] . '"';
        }
        $out = '';
        $pages = str_replace(',', '', $this->Paginator->counter('{{pages}}'));
        $out .= '<select name="go-to-page" class="form-control" onchange="window.location=$(this).val()" ' . $style . '>';
        $out .= $this->Paginator->numbers([
            'start' => 1,
            'last' => $pages,
            'modulus' => $pages,
            'templates' => [
                'number' => '<option value="{{url}}">{{text}}</option>',
                'current' => '<option value="{{url}}" selected>{{text}}</option>'
            ]
        ]);
        $out .= '</select>';
        return $out;
    }

}
