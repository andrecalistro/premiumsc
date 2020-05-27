<?php

namespace Admin\Model\Table;

use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attributes Model
 *
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsToMany $Products
 * @property HasMany $ProductsAttributes
 *
 * @method \Admin\Model\Entity\Attribute get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Attribute newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Attribute[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Attribute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Attribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Attribute[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Attribute findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AttributesTable extends AppTable
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

        $this->setTable('attributes');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Products', [
            'foreignKey' => 'attributes_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'products_attributes',
            'className' => 'Admin.Products'
        ]);
        $this->hasMany('ProductsAttributes', [
            'foreignKey' => 'attributes_id',
            'className' => 'ProductsAttributes'
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
            ->notEmpty('name', __('Por favor, preencha o nome.'));

        $validator
            ->allowEmpty('slug');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return ['file' => 'Arquivo', 'image' => 'Imagem', 'text' => 'Texto'];
    }
}
