<?php

namespace Api\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class PagesController
 * @package Api\Controller
 *
 * @property \Theme\Controller\PagesController $Pages
 */
class PagesController extends AppController
{
    /**
     * @var
     */
    public $Pages;

    /**
     *
     */
    public function initialize()
    {
        parent::initialize();
        $this->Pages = TableRegistry::getTableLocator()->get(Configure::read('Theme') . '.Pages');
    }

    /**
     *
     */
    public function index()
    {
        $pages = $this->Pages->find()
            ->select(['Pages.id', 'Pages.name', 'Pages.slug'])
            ->where(['Pages.status' => 1])
            ->order(['Pages.name' => 'ASC'])
            ->toArray();

        $this->set([
            'pages' => $pages,
            '_serialize' => ['pages']
        ]);
    }
}