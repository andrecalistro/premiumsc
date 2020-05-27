<?php

namespace Subscriptions\Model\Table;

use Admin\Model\Table\AppTable;
use Admin\Model\Table\PaymentsTable;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Association\HasMany;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Subscriptions\Model\Entity\Plan;
use Subscriptions\Model\Entity\PlanBillingFrequency;

/**
 * Plans Model
 *
 * @property \Subscriptions\Model\Table\PlanDeliveryFrequenciesTable|\Cake\ORM\Association\BelongsTo $PlanDeliveryFrequencies
 * @property \Subscriptions\Model\Table\PlanBillingFrequenciesTable|\Cake\ORM\Association\BelongsTo $PlanBillingFrequencies
 * @property PlansImagesTable|HasMany $PlansImages
 * @property SubscriptionsTable|HasMany $Subscriptions
 *
 * @method \Subscriptions\Model\Entity\Plan get($primaryKey, $options = [])
 * @method \Subscriptions\Model\Entity\Plan newEntity($data = null, array $options = [])
 * @method \Subscriptions\Model\Entity\Plan[] newEntities(array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\Plan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\Plan|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Subscriptions\Model\Entity\Plan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\Plan[] patchEntities($entities, array $data, array $options = [])
 * @method \Subscriptions\Model\Entity\Plan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlansTable extends AppTable
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

        $this->setTable('plans');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PlanDeliveryFrequencies', [
            'foreignKey' => 'frequency_delivery_id',
            'className' => 'Subscriptions.PlanDeliveryFrequencies'
        ]);
        $this->belongsTo('PlanBillingFrequencies', [
            'foreignKey' => 'frequency_billing_id',
            'className' => 'Subscriptions.PlanBillingFrequencies'
        ]);

        $this->hasMany('PlansImages', [
            'foreignKey' => 'plans_id',
            'className' => 'Subscriptions.PlansImages'
        ]);

        $this->hasMany('Subscriptions', [
            'foreignKey' => 'plans_id',
            'className' => 'Subscriptions.Subscriptions'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmpty('name');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->date('due_at')
            ->requirePresence('due_at', 'create')
            ->allowEmpty('due_at');

        $validator
            ->decimal('price')
            ->allowEmpty('price');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->decimal('weight')
            ->allowEmpty('weight');

        $validator
            ->decimal('length')
            ->allowEmpty('length');

        $validator
            ->decimal('width')
            ->allowEmpty('width');

        $validator
            ->decimal('height')
            ->allowEmpty('height');

        $validator
            ->integer('shipping_required')
            ->allowEmpty('shipping_required');

        $validator
            ->integer('shipping_free')
            ->allowEmpty('shipping_free');

        $validator
            ->scalar('seo_title')
            ->maxLength('seo_title', 255)
            ->allowEmpty('seo_title');

        $validator
            ->scalar('seo_description')
            ->allowEmpty('seo_description');

        $validator
            ->scalar('seo_url')
            ->maxLength('seo_url', 255)
            ->allowEmpty('seo_url');

        $validator
            ->allowEmpty('seo_image');

        $validator
            ->allowEmpty('pagseguro_reference');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

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
        $rules->add($rules->existsIn(['frequency_delivery_id'], 'PlanDeliveryFrequencies'));
        $rules->add($rules->existsIn(['frequency_billing_id'], 'PlanBillingFrequencies'));

        return $rules;
    }

    /**
     * @param Event $event
     * @param \ArrayObject $data
     * @param \ArrayObject $options
     */
    public function beforeMarshal(Event $event, \ArrayObject $data, \ArrayObject $options)
    {
        /**
         * delete the images inputs empty
         */
        if (isset($data['plans_images'])) {
            foreach ($data['plans_images'] as $keyImage => $image) {
                if ($image['image']['error'] > 0) {
                    unset($data['plans_images'][$keyImage]);
                } else {
                    if ($keyImage == 0) {
                        $data['plans_images'][$keyImage]['main'] = 1;
                    }
                }
            }
        }
        /**
         * format values numbers
         */
        if (isset($data['price'])) {
            $data['price'] = str_replace(',', '.', str_replace('.', '', $data['price']));
        }
        if (isset($data['weight'])) {
            $data['weight'] = str_replace(',', '.', $data['weight']);
        }
        if (isset($data['width'])) {
            $data['width'] = str_replace(',', '.', $data['width']);
        }
        if (isset($data['length'])) {
            $data['length'] = str_replace(',', '.', $data['length']);
        }
        if (isset($data['height'])) {
            $data['height'] = str_replace(',', '.', $data['height']);
        }

        if (isset($data['seo_url']) && empty($data['seo_url'])) {
            $data['seo_url'] = strtolower(Text::slug($data['name']));
        } else {
            if (isset($data['seo_url']))
                $data['seo_url'] = strtolower(Text::slug($data['seo_url']));
        }

        /**
         * expiration_date
         */
        if (isset($data['due_at']) && !empty($data['due_at'])) {
            $data['due_at'] = Time::createFromFormat('d/m/Y', $data['due_at'], 'America/Sao_Paulo');
        }
    }

    /**
     * @param Event $event
     * @param Plan $entity
     * @param \ArrayObject $options
     * @return Plan
     * @throws \Exception
     */
    public function afterSave(Event $event, Plan $entity, \ArrayObject $options)
    {
        return $this->createPagseguroReference($entity);
    }

    /**
     * @param $frequencyBillingName
     * @return string
     */
    private function getPagseguroPeriod($frequencyBillingName)
    {
        switch (Text::slug($frequencyBillingName)) {
            case 'semanal':
                return 'WEEKLY';
            case 'mensal':
                return 'MONTHLY';
            case 'trimestral':
                return 'TRIMONTHLY';
            case 'semestral':
                return 'SEMIANNUALLY';
            case 'anual':
                return 'YEARLY';
            default:
                return 'MONTHLY';
        }
    }

    /**
     * @param $images
     * @param $planId
     * @return bool|EntityInterface[]|\Cake\ORM\ResultSet
     */
    public function saveImages($images, $planId)
    {
        if (!$images) {
            return false;
        }

        foreach ($images as $key => $image) {
            if ($image['image']['error'] !== 0) {
                unset($images[$key]);
                continue;
            }

            if ($key === 0) {
                $images[$key]['main'] = 1;
            }

            $images[$key]['plans_id'] = $planId;
        }

        if (!$images) {
            return false;
        }

        $planImages = $this->PlansImages->newEntities($images);
        try {
            return $this->PlansImages->saveMany($planImages);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $planId
     * @return string|\Subscriptions\Model\Entity\Plan|null
     */
    public function getPlan($planId)
    {
        try {
            return $this->get($planId, [
                'contain' => [
                    'PlanBillingFrequencies',
                    'PlanDeliveryFrequencies',
                    'PlansImages'
                ]
            ]);
        } catch (\Exception $e) {
            return __(sprintf('Plano #%s não encontrado', $planId));
        }
    }

    private function createPagseguroReference(Plan $entity)
    {
        if (!empty($entity->pagseguro_reference)) {
            return $entity;
        }

        /** @var PaymentsTable $paymentsTable */
        $paymentsTable = TableRegistry::getTableLocator()->get('Admin.Payments');
        $pagseguro = $paymentsTable->findConfig('pagseguro_credit_card');

        if (empty($pagseguro) || !$pagseguro->status) {
            return $entity;
        }

        /** @var PlanBillingFrequency $billingFrequency */
        $billingFrequency = $this->PlanBillingFrequencies->get($entity->frequency_billing_id);

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");
        \PagSeguro\Configuration\Configure::setEnvironment($pagseguro->environment);

        $plan = new \PagSeguro\Domains\Requests\DirectPreApproval\Plan();
        $plan->setRedirectURL(Router::url('/', true));
        $plan->setReference(sprintf('plan_%s_%s', $entity->id, Text::slug($entity->name, ['replacement' => '_'])));
        $plan->setPreApproval()->setName($entity->name);
        $plan->setPreApproval()->setCharge('MANUAL');
        $plan->setPreApproval()->setPeriod($this->getPagseguroPeriod($billingFrequency->name));
        $plan->setPreApproval()->setTrialPeriodDuration(1);
        $plan->setPreApproval()->setDetails($entity->name);
//        $plan->setPreApproval()->setFinalDate((new \DateTime())->add(new \DateInterval("P5Y"))->format("Y-m-d"));
        $plan->setReceiver()->withParameters($pagseguro->email);

        try {
            $response = $plan->register(
                new \PagSeguro\Domains\AccountCredentials($pagseguro->email, $pagseguro->token)
            );

            $entity->pagseguro_reference = $response->code;
            $this->save($entity);
            return $entity;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
