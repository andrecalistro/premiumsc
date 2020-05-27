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
 * StoresMenusItems Model
 *
 * @property \Admin\Model\Table\StoresMenusItemsTable|\Cake\ORM\Association\BelongsTo $ParentStoresMenusItems
 * @property \Admin\Model\Table\StoresMenusGroupsTable|\Cake\ORM\Association\BelongsTo $StoresMenusGroups
 * @property \Admin\Model\Table\StoresMenusItemsTable|\Cake\ORM\Association\HasMany $ChildStoresMenusItems
 *
 * @method \Admin\Model\Entity\StoresMenusItem get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\StoresMenusItem newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusItem[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\StoresMenusItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusItem[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\StoresMenusItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StoresMenusItemsTable extends AppTable
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

        $this->setTable('stores_menus_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentStoresMenusItems', [
            'className' => 'Admin.StoresMenusItems',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('StoresMenusGroups', [
            'foreignKey' => 'stores_menus_groups_id',
            'className' => 'Admin.StoresMenusGroups'
        ]);
        $this->hasMany('ChildStoresMenusItems', [
            'className' => 'Admin.StoresMenusItems',
            'foreignKey' => 'parent_id'
        ]);

		$this->addBehavior('Josegonzalez/Upload.Upload', [
			'icon_image' => [
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
		$validator->setProvider('upload', \Josegonzalez\Upload\Validation\UploadValidation::class);

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('name');

        $validator
            ->allowEmpty('slug');

        $validator
			->allowEmpty('menu_type')
            ->allowEmpty('url');

        $validator
            ->allowEmpty('target');

        $validator
            ->allowEmpty('icon_class')
			->allowEmpty('icon_image');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->integer('position')
            ->allowEmpty('position');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

		$validator
			->add('icon_image', 'fileBelowMaxSize', [
				'rule' => ['isBelowMaxSize', 3145728],
				'message' => 'A imagem é grande. O tamanho máximo é de 3MB.',
				'provider' => 'upload'
			]);

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentStoresMenusItems'));
        $rules->add($rules->existsIn(['stores_menus_groups_id'], 'StoresMenusGroups'));

        return $rules;
    }
}
