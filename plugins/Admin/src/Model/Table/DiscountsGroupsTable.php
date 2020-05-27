<?php

namespace Admin\Model\Table;

use Admin\Model\Entity\Menu;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Void_;

/**
 * DiscountsGroups Model
 *
 * @property \Admin\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsToMany $Customers
 * @property |\Cake\ORM\Association\BelongsToMany $Products
 *
 * @method \Admin\Model\Entity\DiscountsGroup get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\DiscountsGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DiscountsGroupsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('discounts_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Customers', [
            'foreignKey' => 'discounts_groups_id',
            'targetForeignKey' => 'customers_id',
            'joinTable' => 'discount_group_customers',
            'className' => 'Admin.Customers'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'discounts_groups_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'discount_group_products',
            'className' => 'Admin.Products'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('free_shipping')
            ->requirePresence('free_shipping', 'create')
            ->notEmpty('free_shipping');

        $validator
            ->scalar('discount')
            ->maxLength('discount', 11)
            ->requirePresence('discount', 'create')
            ->notEmpty('discount');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * @return Menu|array
     */
    public function setMenu($status)
    {
        /** @var MenusTable $menusTable */
        $menusTable = TableRegistry::getTableLocator()->get('Admin.Menus');

        /** @var Menu $menu */
        $menu = $menusTable->find()
            ->where([
                'Menus.controller' => 'discounts-groups',
                'Menus.plugin' => 'admin'
            ])
            ->first();

        if ($menu) {
            $menu->set('status', $status);
            $menusTable->save($menu);
            return $menu;
        }

        $menu = [
            'name' => 'Grupos de descontos',
            'icon' => null,
            'parent_id' => 27,
            'plugin' => 'admin',
            'controller' => 'discounts-groups',
            'action' => 'index',
            'status' => $status,
            'position' => 3
        ];

        $menu = $menusTable->newEntity($menu);
        $menusTable->save($menu);

        $rulesMenu = [
            'rules_id' => 2,
            'menus_id' => $menu->id
        ];

        /** @var RulesMenusTable $rulesMenuTable */
        $rulesMenuTable = TableRegistry::getTableLocator()->get('admin.RulesMenus');
        $rulesMenu = $rulesMenuTable->newEntity($rulesMenu);
        $rulesMenuTable->save($rulesMenu);

        return $menu;
    }
}
