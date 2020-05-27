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
 * Filters Model
 *
 * @property \Cake\ORM\Association\BelongsTo $FiltersGroups
 *
 * @method \Admin\Model\Entity\Filter get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Filter newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Filter[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Filter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Filter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Filter[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Filter findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FiltersTable extends AppTable
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

        $this->setTable('filters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FiltersGroups', [
            'foreignKey' => 'filters_groups_id',
            'className' => 'Admin.FiltersGroups'
        ]);

		$this->addBehavior('Josegonzalez/Upload.Upload', [
			'seo_image' => [
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
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('description')
            ->allowEmpty('seo_description')
            ->maxLength('seo_description', 156, __("Descrição para SEO deve conter no máximo 156 caracteres."));

		$validator
			->allowEmpty('seo_image');

		$validator
			->add('seo_image', 'fileBelowMaxSize', [
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
        $rules->add($rules->existsIn(['filters_groups_id'], 'FiltersGroups'));

        return $rules;
    }

    /**
     * @param array $conditions
     * @return array
     */
    public function items(array $conditions = [])
    {
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'list_name'
        ])
            ->contain(['FiltersGroups' => function ($q) {
                return $q->select(['name']);
            }])
            ->where($conditions)
            ->toArray();
    }

    /**
     * @param $name
     * @param $filters_groups_id
     * @return int|mixed
     */
    public function verifyAndSaveFilter($name, $filters_groups_id)
    {
        $filter = $this->find()->where(['name' => $name, 'filters_groups_id' => $filters_groups_id])->first();
        if (!$filter) {
            $filter = $this->newEntity(['name' => $name, 'filters_groups_id' => $filters_groups_id]);
            $this->save($filter);
            return $filter->id;
        }
        return $filter->id;
    }
}
