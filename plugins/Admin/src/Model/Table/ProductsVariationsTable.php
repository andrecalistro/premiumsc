<?php

namespace Admin\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

/**
 * ProductsVariations Model
 *
 * @property \Admin\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 * @property \Admin\Model\Table\VariationsTable|\Cake\ORM\Association\BelongsTo $Variations
 * @property \Admin\Model\Table\VariationsGroupsTable|\Cake\ORM\Association\BelongsTo $VariationsGroups
 *
 * @method \Admin\Model\Entity\ProductsVariation get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\ProductsVariation newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\ProductsVariation[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\ProductsVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\ProductsVariation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsVariationsTable extends AppTable
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

        $this->setTable('products_variations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Products', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.Products'
        ]);
        $this->belongsTo('Variations', [
            'foreignKey' => 'variations_id',
            'className' => 'Admin.Variations'
        ]);
        $this->belongsTo('VariationsGroups', [
            'foreignKey' => 'variations_groups_id',
            'className' => 'Admin.VariationsGroups'
        ]);

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'image' => [
                'path' => 'webroot{DS}img{DS}files{DS}{model}{DS}',
                'nameCallback' => function ($data = null, $settings = null) {
                    $path = pathinfo($data['name']);
                    return uniqid() . '.' . $path['extension'];
                },
                'transformer' => function (RepositoryInterface $table, EntityInterface $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    $size = new Box(100, 100);
                    $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
            ],
            'auxiliary_field' => [
                'path' => 'webroot{DS}img{DS}files{DS}{model}{DS}',
                'nameCallback' => function ($data = null, $settings = null) {
                    $path = pathinfo($data['name']);
                    return uniqid() . '.' . $path['extension'];
                },
                'transformer' => function (RepositoryInterface $table, EntityInterface $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);
                    $tmp = tempnam(sys_get_temp_dir(), 'upload') . '.' . $extension;
                    $size = new Box(100, 100);
                    $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp);
                    return [
                        $data['tmp_name'] => $data['name'],
                        $tmp => 'thumbnail-' . $data['name'],
                    ];
                },
            ]
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
            ->integer('required')
            ->allowEmpty('required');

        $validator
            ->integer('stock')
            ->allowEmpty('stock')
            ->allowEmpty('sku');

        $validator
            ->allowEmpty('image')
			->allowEmpty('auxiliary_field');

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
        $rules->add($rules->existsIn(['products_id'], 'Products'));
        $rules->add($rules->existsIn(['variations_id'], 'Variations'));
        $rules->add($rules->existsIn(['variations_groups_id'], 'VariationsGroups'));

        return $rules;
    }
}
