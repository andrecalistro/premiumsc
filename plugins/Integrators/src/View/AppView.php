<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace Integrators\View;

use Cake\View\View;

/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
        if($this->request->getParam('controller') == 'Bling') {
            $this->Html->css(['Integrators.bling.css'], ['block' => 'cssTop', 'fullBase' => true]);
        }

        $this->Form->setTemplates([
            'submitContainer' => '{{content}}'
        ]);

        $this->Paginator->setTemplates([
            'nextActive' => '<a href="{{url}}">{{text}}</a>',
            'nextDisabled' => '<a href="javascript:void(0)">{{text}}</a>',
            'prevActive' => '<a href="{{url}}">{{text}}</a>',
            'prevDisabled' => '<a href="javascript:void(0)">{{text}}</a>',
        ]);
    }
}
