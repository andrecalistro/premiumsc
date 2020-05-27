<?php

namespace Admin\Model\Table;

use Cake\ORM\Table;
use SoftDelete\Model\Table\SoftDeleteTrait;

/**
 * Class AppTable
 * @package Admin\Model\Table
 */
class AppTable extends Table
{
    use SoftDeleteTrait;

    /**
     * @param $conditions
     * @return int
     */
    public function hardDeleteAllCondition($conditions)
    {
        $query = $this->query()
            ->delete()
            ->where($conditions);
        $statement = $query->execute();
        $statement->closeCursor();
        return $statement->rowCount();
    }
}