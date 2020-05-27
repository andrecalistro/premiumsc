<?php

namespace Email\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
    }
}
