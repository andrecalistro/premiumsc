<?php

namespace CheckoutV2\Model\Table;

use Cake\ORM\Table;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Class AppTable
 * @package App\Model\Table
 */
class AppTable extends Table
{
    use SoftDeleteTrait;
}