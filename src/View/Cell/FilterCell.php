<?php

namespace App\View\Cell;

use Cake\Event\EventManager;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Filter cell
 *
 * @property \App\Model\Table\FiltersGroupsTable $FiltersGroups
 */
class FilterCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];
    public $FiltersGroups;

    public function __construct($request = null, $response = null, $eventManager = null, array $cellOptions = [])
    {
        parent::__construct($request, $response, $eventManager, $cellOptions);
        $this->FiltersGroups = TableRegistry::get('FiltersGroups');
    }

    /**
     *
     */
    public function display()
    {
        $filtersGroups = $this->FiltersGroups->find()
            ->contain(['Filters'])
            ->toArray();

        $this->set(compact('filtersGroups'));
    }
}
