<?php

namespace Admin\Model\Table;

use ArrayObject;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Entity;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

/**
 * ProductsAttributes Model
 *
 * @property \Admin\Model\Table\AttributesTable|\Cake\ORM\Association\BelongsTo $Attributes
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \Admin\Model\Entity\ProductsAttribute get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsAttribute newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsAttribute[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsAttribute|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsAttribute patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsAttribute[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsAttribute findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsAttributesTable extends AppTable
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

        $this->setTable('products_attributes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Attributes', [
            'foreignKey' => 'attributes_id',
            'className' => 'Admin.Attributes'
        ]);
        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
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
            ->allowEmpty('value');
//            ->notEmpty('value', __('Por favor, preencha o valor.'));

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['attributes_id'], 'Attributes'));
        $rules->add($rules->existsIn(['products_id'], 'Products'));

        return $rules;
    }

    /**
     * @param Event $event
     * @param ArrayObject $data
     * @param ArrayObject $options
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        /**
         * Upload file if value is file or image
         */
        if (isset($data['value']['error']) && $data['value']['error'] == 0) {
            $file_uploaded = $data['value'];
            $data['value'] = null;
            if ($file_uploaded['type'] == 'application/pdf') {
                $file_name = uniqid() . '.' . strtolower(pathinfo($file_uploaded['name'], PATHINFO_EXTENSION));

                $dir = new Folder(WWW_ROOT . 'img' . DS . 'files' . DS . 'ProductsAttributes', true, 755);
                $tmp_file = new File($file_uploaded['tmp_name']);
                if ($tmp_file->exists()) {
                    if ($tmp_file->copy($dir->pwd() . DS . $file_name)) {
                        $data['value'] = $file_name;
                    }
                }
                $tmp_file->delete();
            }
        }
    }
}
