<?php

namespace Admin\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Integrators\Model\Table\BlingProvidersTable;

/**
 * Providers Model
 *
 * @property \Cake\ORM\Association\HasMany $Products
 * @property BlingProvidersTable $BlingProviders
 *
 * @method \Admin\Model\Entity\Provider get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Provider newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Provider[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Provider|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Provider patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Provider[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Provider findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProvidersTable extends AppTable
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

        $this->setTable('providers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Products', [
            'foreignKey' => 'providers_id',
            'className' => 'Admin.Products'
        ]);

        $this->hasMany('BlingProviders', [
            'foreignKey' => 'providers_id',
            'className' => 'Integrators.BlingProviders'
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
            ->notEmpty('name', __("Por favor, preencha o nome."));

        $validator
            ->allowEmpty('slug');

        $validator
            ->allowEmpty('image');

        $validator
            ->integer('status')
            ->allowEmpty('status')
            ->allowEmpty('email')
            ->allowEmpty('telephone')
            ->allowEmpty('bank')
            ->allowEmpty('agency')
            ->allowEmpty('account')
            ->notEmpty('document', __('Por favor, preencha o CPF ou CNPJ.'));

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * @param $name
     * @return int
     */
    public function verifyAndSave($name)
    {
        $provider = $this->find()->where(['name' => $name])->first();
        if (!$provider) {
            $provider = $this->newEntity(['name' => $name, 'status' => 1]);
            $this->save($provider);
            return $provider->id;
        }
        return $provider->id;
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $Bling = TableRegistry::getTableLocator()->get('Admin.Stores');
        $config = $Bling->findConfig('bling');
        if (($config->status) && ($config->synchronize_providers) && !empty($config->api_key)) {
            $this->BlingProviders->postProvider($entity->id);
        }
    }
}
