<?php

namespace Admin\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Cake\ORM\Association\HasMany $ChildCategories
 * @property \Cake\ORM\Association\BelongsToMany $Products
 * @property \Cake\ORM\Association\BelongsTo $ProductsMain
 * @property \Cake\ORM\Association\HasMany $ProductsCategories
 *
 * @method \Admin\Model\Entity\Category get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoriesTable extends AppTable
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

        $this->setTable('categories');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentCategories', [
            'className' => 'Admin.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildCategories', [
            'className' => 'Admin.Categories',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsToMany('Products', [
            'foreignKey' => 'categories_id',
            'targetForeignKey' => 'products_id',
            'joinTable' => 'products_categories',
            'className' => 'Admin.Products'
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

        $this->belongsTo('ProductsMain', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.Products'
        ]);

        $this->hasMany('ProductsCategories', [
            'className' => 'Admin.ProductsCategories',
            'foreignKey' => 'categories_id'
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
            ->allowEmpty('title');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('description');

        $validator
            ->allowEmpty('seo_description');

        $validator
            ->allowEmpty('seo_title');

        $validator
            ->allowEmpty('seo_url');

		$validator
			->allowEmpty('seo_image');

        $validator
            ->allowEmpty('image');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('products_id')
            ->allowEmpty('products_total')
            ->allowEmpty('slug')
            ->allowEmpty('abbreviation')
            ->allowEmpty('show_featured_menu')
			->allowEmpty('release_date')
			->allowEmpty('expiration_date');

        $validator
            ->add('image', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 3145728],
                'message' => 'A imagem é grande. O tamanho máximo é de 3MB.',
                'provider' => 'upload'
            ]);

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
        $rules->add($rules->existsIn(['parent_id'], 'ParentCategories'));

        return $rules;
    }

	/**
	 * @param Event $event
	 * @param ArrayObject $data
	 * @param ArrayObject $options
	 */
	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		// expiration_date
		if(isset($data['expiration_date']) && !empty($data['expiration_date'])) {
			$data['expiration_date'] = Time::createFromFormat('d/m/Y H:i', $data['expiration_date'], 'America/Sao_Paulo');
		}

		// release_date
		if(isset($data['release_date']) && !empty($data['release_date'])) {
			$data['release_date'] = Time::createFromFormat('d/m/Y H:i', $data['release_date'], 'America/Sao_Paulo');
		}
	}

    /**
     * @param array $conditions
     * @return array
     */
    public function items(array $conditions = [])
    {
        return $this->find('list', [
            'keyField' => 'id',
            'valueField' => 'list_title'
        ])
            ->contain(['ParentCategories' => function ($q) {
                return $q->select(['id', 'title']);
            }])
            ->where($conditions)
            ->toArray();
    }
}
