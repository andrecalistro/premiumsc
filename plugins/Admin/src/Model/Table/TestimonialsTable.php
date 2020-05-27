<?php

namespace Admin\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

/**
 * Testimonials Model
 *
 * @method \Admin\Model\Entity\Testimonial get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Testimonial newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Testimonial[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Testimonial|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Testimonial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Testimonial[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Testimonial findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TestimonialsTable extends AppTable
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

        $this->setTable('testimonials');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'avatar' => [
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
            ->notEmpty('name', __('Por favor, preencha o nome.'));

        $validator
            ->allowEmpty('company');

        $validator
            ->notEmpty('message', __("Por favor, preencha a mensagem."));

        $validator
            ->allowEmpty('avatar');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }
}
