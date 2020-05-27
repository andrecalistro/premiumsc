<?php

namespace Admin\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Event\Event;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

/**
 * BannersImages Model
 *
 * @property \Admin\Model\Table\BannersTable|\Cake\ORM\Association\BelongsTo $Banners
 *
 * @method \Admin\Model\Entity\BannersImage get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\BannersImage newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\BannersImage[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\BannersImage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\BannersImage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\BannersImage[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\BannersImage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BannersImagesTable extends AppTable
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

        $this->setTable('banners_images');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Banners', [
            'foreignKey' => 'banners_id',
            'className' => 'Admin.Banners'
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
            'image_mobile' => [
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
            'background' => [
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
            'background_mobile' => [
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
            ->allowEmpty('background')
            ->allowEmpty('background_mobile')
            ->allowEmpty('image_mobile');

        $validator
            ->allowEmpty('image');

        $validator
            ->allowEmpty('path');

        $validator
            ->integer('status')
            ->allowEmpty('status');

        $validator
            ->date('validate')
            ->allowEmpty('validate');

        $validator
            ->integer('always')
            ->allowEmpty('always');

        $validator
            ->integer('sunday')
            ->allowEmpty('sunday');

        $validator
            ->integer('monday')
            ->allowEmpty('monday');

        $validator
            ->integer('tuesday')
            ->allowEmpty('tuesday');

        $validator
            ->integer('wednesday')
            ->allowEmpty('wednesday');

        $validator
            ->integer('thursday')
            ->allowEmpty('thursday');

        $validator
            ->integer('friday')
            ->allowEmpty('friday');

        $validator
            ->integer('saturday')
            ->allowEmpty('saturday');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('image_width')
            ->allowEmpty('image_height')
            ->allowEmpty('background_width')
            ->allowEmpty('background_height')
            ->allowEmpty('image_mobile_width')
            ->allowEmpty('image_mobile_height')
            ->allowEmpty('background_mobile_width')
            ->allowEmpty('background_mobile_height')
            ->allowEmpty('text_link')
            ->allowEmpty('description')
            ->allowEmpty('title')
            ->allowEmpty('subtitle');

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
        $rules->add($rules->existsIn(['banners_id'], 'Banners'));

        return $rules;
    }
}
