<?php

namespace Theme\View;

use Cake\View\View;

class CustomView extends View
{
    public function initialize()
    {
        $this->Paginator->setTemplates([
            'sortAsc' => '{{url}}',
            'sortDesc' => '{{url}}',
            'sort' => '{{url}}',
            'sortAscLocked' => '{{url}}',
            'sortDescLocked' => '{{url}}',
            'nextActive' => '<li><a class="next" rel="next" href="{{url}}">{{text}}</a></li>',
            'nextDisabled' => '<li><a class="next disabled" href="" onclick="return false;">{{text}}</a></li>',
            'prevActive' => '<li><a class="prev" rel="prev" href="{{url}}">{{text}}</a></li>',
            'prevDisabled' => '<li><a class="prev disabled" href="" onclick="return false;">{{text}}</a></li>',
        ]);
    }
}
