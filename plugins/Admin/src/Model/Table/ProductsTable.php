<?php

namespace Admin\Model\Table;

use Admin\Model\ProductTrait;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\RepositoryInterface;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\Association\BelongsToMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Utility\Text;
use Cake\Validation\Validator;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Integrators\Model\Table\BlingProductsTable;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $Positions
 * @property \Cake\ORM\Association\HasMany $ProductsImages
 * @property \Cake\ORM\Association\BelongsToMany $Filters
 * @property \Cake\ORM\Association\BelongsToMany $Attributes
 * @property \Cake\ORM\Association\HasMany $ProductsAttributes
 * @property \Cake\ORM\Association\BelongsTo $ProductsFeatured
 * @property \Cake\ORM\Association\BelongsToMany $ProductsChilds
 * @property \Cake\ORM\Association\HasMany $ProductsTabs
 * @property \Cake\ORM\Association\BelongsTo $Providers
 * @property \Cake\ORM\Association\BelongsTo $ProductsConditions
 * @property \Cake\ORM\Association\BelongsTo $ProductsStatuses
 * @property \Cake\ORM\Association\HasOne $ProductsSales
 * @property BlingProductsTable $BlingProducts
 * @property OrdersProductsTable $OrdersProducts
 * @property VariationsTable $Variations
 * @property VariationsGroupsTable $VariationsGroups
 * @property ProductsVariationsTable $ProductsVariations
 *
 * @method \Admin\Model\Entity\Product get($primaryKey, $options = [])
 * @method \Admin\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \Admin\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \Admin\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Admin\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Admin\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \Admin\Model\Entity\Product findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends AppTable
{
    use ProductTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'categories_id',
            'className' => 'Admin.Categories'
        ]);
        $this->belongsTo('Positions', [
            'foreignKey' => 'positions_id',
            'className' => 'Admin.positions'
        ]);
        $this->belongsToMany('Categories', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'categories_id',
            'joinTable' => 'products_categories',
            'className' => 'Admin.Categories'
        ]);
        $this->hasMany('ProductsImages', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsImages'
        ]);
        $this->belongsToMany('Filters', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'filters_id',
            'joinTable' => 'products_filters',
            'className' => 'Admin.Filters'
        ]);
        $this->belongsToMany('Attributes', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'attributes_id',
            'joinTable' => 'products_attributes',
            'className' => 'Admin.Attributes'
        ]);
        $this->hasMany('ProductsAttributes', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsAttributes'
        ]);

        $this->hasMany('ProductsCategories', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsCategories'
        ]);

        $this->belongsToMany('ProductsChilds', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'childs_id',
            'joinTable' => 'products_relateds',
            'className' => 'Admin.Products'
        ]);

        $this->hasMany('ProductsTabs', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsTabs'
        ]);

        $this->belongsTo('Providers', [
            'foreignKey' => 'providers_id',
            'className' => 'Admin.Providers'
        ]);

        $this->belongsTo('ProductsConditions', [
            'foreignKey' => 'products_conditions_id',
            'className' => 'Admin.ProductsConditions'
        ]);

        $this->belongsTo('ProductsStatuses', [
            'foreignKey' => 'status',
            'className' => 'Admin.ProductsStatuses'
        ]);

        $this->hasMany('ProductsSales', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsSales'
        ]);

        $this->hasMany('BlingProducts', [
            'foreignKey' => 'products_id',
            'className' => 'Integrators.BlingProducts'
        ]);

        $this->hasMany('OrdersProducts', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.OrdersProducts'
        ]);

        $this->belongsToMany('Variations', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'variations_id',
            'joinTable' => 'products_variations',
            'className' => 'Admin.Variations'
        ]);

        $this->belongsToMany('VariationsGroups', [
            'foreignKey' => 'products_id',
            'targetForeignKey' => 'variations_groups_id',
            'joinTable' => 'products_variations',
            'conditions' => ['ProductsVariations.deleted' => 'IS NULL'],
            'className' => 'Admin.VariationsGroups'
        ]);

        $this->hasMany('ProductsVariations', [
            'foreignKey' => 'products_id',
            'className' => 'Admin.ProductsVariations'
        ]);

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'image_background' => [
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
            ->notEmpty('name', __('Por favor, preencha o nome do produto.'))
            ->notEmpty('code', __('Por favor, preencha o codigo do produto.'));

        $validator
            ->allowEmpty('tags');

        $validator
            ->integer('stock')
            ->allowEmpty('stock');

        $validator
            ->decimal('price')
            ->notEmpty('price', __('Por favor, preencha o preço'));

        $validator
            ->decimal('price_special')
            ->allowEmpty('price_special');

        $validator
            ->integer('stock_control')
            ->allowEmpty('stock_control');

        $validator
            ->integer('show_price')
            ->allowEmpty('show_price');

        $validator
            ->allowEmpty('description');

        $validator
            ->decimal('weight')
            ->notEmpty('weight', __('Por favor, preencha o peso'));

        $validator
            ->decimal('length')
            ->notEmpty('length', __('Por favor, preencha o comprimento'));

        $validator
            ->decimal('width')
            ->notEmpty('width', __('Por favor, preencha a largura'));

        $validator
            ->decimal('height')
            ->notEmpty('height', __('Por favor, preencha a altura'));

        $validator
            ->integer('shipping_free')
            ->allowEmpty('shipping_free');

        $validator
            ->allowEmpty('seo_title')
            ->maxLength('seo_title', 120, __("Título para SEO deve conter no máximo 120 caracteres."));

        $validator
            ->allowEmpty('seo_description')
            ->maxLength('seo_description', 156, __("Descrição para SEO deve conter no máximo 156 caracteres."));

        $validator
            ->allowEmpty('seo_url');

        $validator
            ->allowEmpty('seo_image');

        $validator
            ->integer('main')
            ->allowEmpty('main');

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted')
            ->allowEmpty('image_background')
            ->allowEmpty('video')
            ->allowEmpty('products_id')
            ->add('image_background', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', 3145728],
                'message' => 'A imagem de fundo é grande. O tamanho máximo é de 3MB.',
                'provider' => 'upload'
            ])
            ->allowEmpty('resume')
            ->allowEmpty('ean')
            ->allowEmpty('expiration_date')
            ->allowEmpty('release_date')
            ->allowEmpty('additional_delivery_time');

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
        $rules->add($rules->existsIn(['categories_id'], 'Categories'));
        $rules->add($rules->isUnique(['code'], 'Já existe um produto cadastrado com esse código'));

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
         * Variations
         */
        if (isset($data['products_variations']) && !empty($data['products_variations'])) {
            $data['stock'] = 0;
            foreach ($data['products_variations'] as $variation) {
                $data['stock'] += $variation['stock'];
            }
        }

        /**
         * Providers
         */
        if (isset($data['providers_id']) && !empty($data['providers_id']) && !preg_match('/^[0-9]*$/', $data['providers_id'])) {
            $data['providers_id'] = $this->Providers->verifyAndSave($data['providers_id']);
        }

        /**
         * filters
         */
        if (isset($data['filters_groups']) && !empty($data['filters_groups'])) {
            $data['filters'] = ['_ids' => []];
            foreach ($data['filters_groups'] as $filters_groups_id => $filters_group) {
                foreach ($filters_group as $filter) {
                    $filter_id = $this->Filters->verifyAndSaveFilter($filter, $filters_groups_id);
                    if ($filter_id) {
                        $data['filters']['_ids'][] = $filter_id;
                    }
                }
            }
        }

        /**
         * delete the images inputs empty
         */
        if (isset($data['products_images'])) {
            foreach ($data['products_images'] as $keyImage => $image) {
                if ($image['image']['error'] > 0) {
                    unset($data['products_images'][$keyImage]);
                } else {
                    if ($keyImage == 0) {
                        $data['products_images'][$keyImage]['main'] = 1;
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
        if (isset($data['price_special'])) {
            $data['price_special'] = str_replace(',', '.', str_replace('.', '', $data['price_special']));
        }
        if (isset($data['price_promotional'])) {
            $data['price_promotional'] = str_replace(',', '.', str_replace('.', '', $data['price_promotional']));
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
            $data['seo_url'] = strtolower(Text::slug($data['seo_url']));
        }

        /**
         * expiration_date
         */
        if (isset($data['expiration_date']) && !empty($data['expiration_date'])) {
            $data['expiration_date'] = Time::createFromFormat('d/m/Y H:i', $data['expiration_date'], 'America/Sao_Paulo');
        }

        /**
         * release_date
         */
        if (isset($data['release_date']) && !empty($data['release_date'])) {
            $data['release_date'] = Time::createFromFormat('d/m/Y H:i', $data['release_date'], 'America/Sao_Paulo');
        }

        /**
         * Attributes, removing empty with empty values
         */
        if (isset($data['products_attributes']) && $data['products_attributes']) {
            foreach ($data['products_attributes'] as $key => $products_attribute) {
                if (empty($products_attribute['value']) || (isset($products_attribute['value']['error']) && $products_attribute['value']['error'] > 0)) {
                    unset($data['products_attributes'][$key]);
                }
            }
        }
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     * @var StoresTable $Bling
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $Bling = TableRegistry::getTableLocator()->get('Admin.Stores');
        $config = $Bling->findConfig('bling');
        if (isset($config->status) && ($config->status) && ($config->synchronize_products) && !empty($config->api_key)) {
            $this->BlingProducts->postProduct($entity->id);
        }
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterDelete(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $Bling = TableRegistry::getTableLocator()->get('Admin.Stores');
        $config = $Bling->findConfig('bling');
        if (isset($config->status) && ($config->status) && ($config->synchronize_products) && !empty($config->api_key)) {
            $this->BlingProducts->deleteProduct($entity->id);
        }
    }

    /**
     * @param Query $query
     * @param array $options
     * @return array
     */
    public function findBestSellers(Query $query, array $options)
    {
        return $query
            ->contain([
                'ProductsImages',
                'ProductsSales',
                'Filters' => function ($q) {
                    return $q->contain('FiltersGroups');
                }
            ])
            ->innerJoinWith('ProductsSales')
            ->order(['ProductsSales.count' => 'DESC'])
            ->limit(5)
            ->toArray();
    }
}
