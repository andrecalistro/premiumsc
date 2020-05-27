<?php

namespace Admin\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;

/**
 * Pages Model
 *
 * @method \Admin\Model\Entity\Page get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Page newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Page[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Page|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Page patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Page[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Page findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PagesTable extends AppTable
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

        $this->setTable('pages');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->notEmpty('name', __("Por favor, preencha o nome"));

        $validator
            ->allowEmpty('slug');

        $validator
            ->integer('status')
            ->notEmpty('status', __("Por favor, selecione o status."));

        $validator
            ->notEmpty('content', __("Por favor, preencha o conteudo da página."));

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

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
		return $rules;
	}
}
