<?php

namespace Admin\Controller;

use Cake\Collection\CollectionInterface;
use Cake\Core\Exception\Exception;
use Cake\I18n\Date;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Integrators\Controller\Component\BlingComponent;
use Cake\Routing\Router;

/**
 * Products Controller
 *
 * @property \Admin\Model\Table\ProductsTable $Products
 * @property BlingComponent $Bling
 */
class ProductsController extends AppController
{
    public $garrula;
    public $import_fields;

    /**
     * @throws \Exception
     */
    public function initialize()
    {
        parent::initialize();
        $Garrula = TableRegistry::getTableLocator()->get("Admin.Stores");
        $this->garrula = $Garrula->findConfig('garrula');
        $this->loadComponent('Integrators.Bling');
        $this->import_fields = ['null' => 'Não usar', 'code' => 'Código', 'name' => 'Nome', 'price' => 'Preço', 'price_special' => 'Preço Promocional', 'stock' => 'Estoque'];
    }

    /**
     *
     */
    public function index()
    {
        $this->viewBuilder()->setTemplate('Products/index/' . $this->garrula->template_product_form);
        $conditions = [];
        $filter = [
            'name' => '',
            'code' => '',
            'providers_name' => '',
            'id' => '',
            'stock' => '',
            'price' => '',
            'price_special' => '',
            'title' => '',
            'status' => '',
            'category' => ''
        ];

        if ($this->request->getQuery('name')) {
            $conditions[] = ['Products.name LIKE' => "%{$this->request->getQuery('name')}%"];
            $filter['name'] = $this->request->getQuery('name');
        }

        if ($this->request->getQuery('providers_name')) {
            $conditions[] = ['Providers.name LIKE' => "%{$this->request->getQuery('providers_name')}%"];
            $filter['providers_name'] = $this->request->getQuery('providers_name');
        }

        if ($this->request->getQuery('id')) {
            $conditions[] = ['Products.id' => $this->request->getQuery('id')];
            $filter['id'] = $this->request->getQuery('id');
        }

        if ($this->request->getQuery('code')) {
            $conditions[] = ['Products.code LIKE' => "%{$this->request->getQuery('code')}%"];
            $filter['code'] = $this->request->getQuery('code');
        }

        if ($this->request->getQuery('stock')) {
            $conditions[] = ['Products.stock' => $this->request->getQuery('stock')];
            $this->set('stock', $this->request->getQuery('stock'));
            $filter['stock'] = $this->request->getQuery('stock');
        }

        if ($this->request->getQuery('price')) {
            $price = str_replace(',', '.', str_replace('.', '', $this->request->getQuery('price')));
            $conditions[] = ['Products.price' => $price];
            $this->set('price', $this->request->getQuery('price'));
            $filter['price'] = $this->request->getQuery('price');
        }

        if ($this->request->getQuery('price_special')) {
            $price = str_replace(',', '.', str_replace('.', '', $this->request->getQuery('price_special')));
            $conditions[] = ['Products.price_special' => $price];
            $this->set('price_special', $this->request->getQuery('price_special'));
            $filter['price_special'] = $this->request->getQuery('price_special');
        }

        if ($this->request->getQuery('status')) {
            $conditions[] = ['Products.status' => $this->request->getQuery('status')];
            $filter['status'] = $this->request->getQuery('status');
        }

        if ($this->request->getQuery('title')) {
            $category = $this->Products->Categories->find()
                ->select(['id'])
                ->where(['title LIKE' => "%{$this->request->getQuery('title')}%"])
                ->first();
            if ($category) {
                //$conditions[] = ['ProductsCategories.categories_id' => $category->id];
            }
            $filter['title'] = $this->request->getQuery('title');
        }

        if ($this->request->getQuery('category')) {
            $category = $this->Products->Categories->get($this->request->getQuery('category'), ['contain' => 'ChildCategories']);
            $categories[] = $category->id;
            if ($category->list_categories_child) {
                $categories = array_merge($categories, $category->list_categories_child);
            }
            $filter['category'] = $this->request->getQuery('category');
        }

        $sort = ['Products.id' => 'DESC', 'Products.name' => 'ASC'];
        if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
            $sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
        }

        $query = $this->Products->find()
            ->contain([
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC']);
                },
                'Categories' => function ($q) {
                    return $q->order(['Categories.title' => 'asc']);
                },
                'ProductsCategories',
                'Providers',
                'ProductsStatuses',
                'ProductsVariations'
            ])
            ->where($conditions)
            ->order($sort);

        if ($filter['category']) {
            $query->matching('Categories', function ($q) use ($categories) {
                return $q->where(['Categories.id IN' => $categories]);
            });
        }

        $products = $this->paginate($query);
        $categories = $this->Products->Categories->items();

        $total = $this->request->getParam('paging')['Products']['count'];

        if ($total == 0) {
            $messageTotalProducts = __("NENHUM PRODUTO ENCONTRADO");
        } else {
            $messageTotalProducts = sprintf(__n("%s PRODUTO NA BASE DE DADOS", "%s PRODUTOS NA BASE DE DADOS", $total), $total);
        }
        $table_class = 'products-table-' . $this->garrula->template_product_form;

        $productsStatuses = $this->Products->ProductsStatuses->find('list')->toArray();
        $this->set(compact('products', 'categories', 'messageTotalProducts', 'filter', 'productsStatuses', 'table_class'));
        $this->set('_serialize', ['products']);
    }

    /**
     * @param null $id
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setTemplate('Products/view/' . $this->garrula->template_product_form);
        $product = $this->Products->get($id, [
            'contain' => [
                'Categories',
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC']);
                },
                'Providers',
                'ProductsAttributes',
                'ProductsConditions',
                'Filters' => function ($q) {
                    return $q->contain(['FiltersGroups']);
                },
                'ProductsStatuses',
                'ProductsVariations'
            ]
        ]);
        $attributes = $this->Products->Attributes->find('list')->toArray();
        $filters_groups = $this->Products->Filters->FiltersGroups->find()
            ->toArray();
        $this->set(compact('product', 'attributes', 'filters_groups'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setTemplate('Products/add/' . $this->garrula->template_product_form);
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $retorno = $this->request->getData('urlRetorno');

            $product = $this->Products->patchEntity($product, $this->request->getData(), ['associated' => ['Categories', 'ProductsImages', 'Filters', 'ProductsAttributes', 'ProductsChilds', 'ProductsTabs', 'ProductsVariations']]);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('O produto foi salvo.'));
                $this->Bling->synchronizeProductCrud($product->id);
                if (!$this->request->getData('stay')) {
                        return $this->redirect($retorno);
                } else {
                    return $this->redirect(['controller' => 'products', 'action' => 'edit', $product->id]);
                }
            }
            $this->Flash->error(__('O produto não foi salvo. Por favor, revise o formulário e tente novamente.'));
        } else {
            $refer_url = $this->referer('/', true);
        }

        $categories = $this->Products->Categories->items();
        $stock_controls = $show_prices = $mains = $shipping_control = [0 => 'Não', 1 => 'Sim'];
        $shipping_frees = ['Frete grátis para este produto' => 1];
        $attributes = $this->Products->Attributes->find()->toArray();
        $attributesList = Hash::combine($attributes, '{n}.id', '{n}.name');
        $statuses = [1 => 'Habilitado', 0 => 'Desabilitado'];
        $products = $this->Products->ProductsChilds->find('list')
            ->order(['name' => 'ASC'])
            ->toArray();
        $providers = $this->Products->Providers->find('list')->order(['name' => 'ASC'])->toArray();
        $products_conditions = $this->Products->ProductsConditions->find('list')->order(['id' => 'ASC'])->toArray();
        $filters_groups = $this->Products->Filters->FiltersGroups->find()
            ->contain(['Filters'])
            ->toArray();
        $filters = $this->Products->Filters->items();

        $lastProduct = $this->Products->find('all', ['withDeleted'])
            ->select(['id'])
            ->order(['id' => 'DESC'])
            ->first();

        if ($lastProduct) {
            $products_id = str_pad(($lastProduct->id + 1), 6, 0, STR_PAD_LEFT);
        } else {
            $products_id = str_pad(1, 6, 0, STR_PAD_LEFT);
        }

        $productsStatuses = $this->Products->ProductsStatuses->find('list');
        $VariationsGroups = TableRegistry::getTableLocator()->get('Admin.VariationsGroups');
        $variationsGroups = $VariationsGroups->find('list')->order(['VariationsGroups.name' => 'ASC']);

        $this->set(compact('product', 'categories', 'stock_controls', 'show_prices', 'shipping_frees', 'filters', 'attributes', 'products', 'statuses', 'providers', 'products_conditions', 'filters_groups', 'products_id', 'productsStatuses', 'variationsGroups', 'shipping_control', 'attributesList','refer_url'));
        $this->set('_serialize', ['product']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        

        $this->viewBuilder()->setTemplate('Products/edit/' . $this->garrula->template_product_form);
        $product = $this->Products->get($id, [
            'contain' => [
                'Filters',
                'Categories',
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC']);
                },
                'ProductsAttributes' => function ($q) {
                    return $q->contain(['Attributes']);
                },
                'ProductsChilds',
                'ProductsTabs' => function ($q) {
                    return $q->order(['ProductsTabs.order_show' => 'ASC']);
                },
                'Variations' => function ($q) {
                    return $q->contain(['ProductsVariations']);
                },
                'ProductsVariations' => function ($q) {
                    return $q->contain(['VariationsGroups' => function ($q) {
                        return $q->contain(['Variations']);
                    }]);
                }
            ]
        ]);

        $product->variations_groups = Hash::combine(Hash::extract($product, 'products_variations.{n}.variations_group'), '{n}.id', '{n}');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $retorno = $this->request->getData('urlRetorno');
            $product = $this->Products->patchEntity($product, $this->request->getData(), ['associated' => ['Categories', 'ProductsImages', 'Filters', 'ProductsAttributes', 'ProductsChilds', 'ProductsTabs', 'ProductsVariations']]);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('O produto foi salvo.'));
                if (!$this->request->getData('stay')) {
                        return $this->redirect($retorno);
                } else {
                    return $this->redirect(['controller' => 'products', 'action' => 'edit', $product->id]);
                }
            }
            $this->Flash->error(__('O produto não foi salvo. Por favor, revise o formulário e tente novamente.'));
        } else {
            $refer_url = $this->referer('/', true);
        }
        isset($product->products_images) ? $count_images = 5 - count($product->products_images) : $count_images = 5;

        $categories = $this->Products->Categories->items();

        $filters_groups = $this->Products->Filters->FiltersGroups->find()
            ->contain(['Filters'])
            ->toArray();
        $filters = $this->Products->Filters->items();

        $stock_controls = $show_prices = $mains = $shipping_control = [0 => 'Não', 1 => 'Sim'];
        $statuses = [1 => 'Habilitado', 0 => 'Desabilitado'];
        $shipping_frees = ['Frete grátis para este produto' => 1];
        $attributes = $this->Products->Attributes->find()->toArray();
        $attributesList = Hash::combine($attributes, '{n}.id', '{n}.name');
        $products = $this->Products->ProductsChilds->find('list')
            ->where(['ProductsChilds.id <>' => $id])
            ->order(['name' => 'ASC'])
            ->toArray();
        $providers = $this->Products->Providers->find('list')->order(['name' => 'ASC'])->toArray();
        $products_conditions = $this->Products->ProductsConditions->find('list')->order(['id' => 'ASC'])->toArray();
        $productsStatuses = $this->Products->ProductsStatuses->find('list');

        $VariationsGroups = TableRegistry::getTableLocator()->get('Admin.VariationsGroups');
        $variationsGroupsContent = $VariationsGroups->find('list')->order(['VariationsGroups.name' => 'ASC']);

        $this->set(compact('product', 'categories', 'stock_controls', 'show_prices', 'shipping_frees', 'count_images', 'filters', 'attributes', 'products', 'statuses', 'providers', 'products_conditions', 'filters_groups', 'productsStatuses', 'variationsGroupsContent', 'shipping_control', 'attributesList','refer_url'));
        $this->set('_serialize', ['product']);
    }

    /**
     * @param null $id
     */
    public function editProvidersStatus($id = null)
    {
        $product = $this->Products->get($id);

        $json = [
            'status' => false,
            'message' => ''
        ];

        if ($product->providers_payment_status) {
            $product->providers_payment_status = 0;
        } else {
            $product->providers_payment_status = 1;
        }

        if ($this->Products->save($product)) {
            $json['status'] = true;
            $json['message'] = 'Status de pagamento alterado com sucesso';
            $json['providers_payment_status'] = $product->providers_payment_status;
        } else {
            $json['message'] = 'Houve um problema ao alterar o status de pagamento. Por favor, tente novamente.';
        }

        $this->set(compact('json'));
        $this->set('_serialize', ['json']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('O produto foi excluído.'));
        } else {
            $this->Flash->error(__('O produto não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $id
     * @param $products_id
     * @return \Cake\Http\Response|null
     */
    public function deleteImage($id = null, $products_id = null)
    {
        if (!$id && !$products_id) {
            return $this->redirect(['controller' => 'products', 'action' => 'index']);
        }
        $image = $this->Products->ProductsImages->get($id);
        if ($image && $this->Products->ProductsImages->delete($image)) {
            $this->Flash->success(__('A imagem foi excluída.'));
        } else {
            $this->Flash->error(__('A imagem não foi excluída. Por favor, tente novamente.'));
        }
        return $this->redirect(['action' => 'edit', $products_id]);
    }

    /**
     * @param $id
     * @param $products_id
     * @return \Cake\Http\Response|null
     */
    public function setImageMain($id, $products_id)
    {
        $image = $this->Products->ProductsImages->get($id);
        $this->Products->ProductsImages->updateAll(
            ['main' => 0],
            ['products_id' => $products_id]
        );
        if ($image && $this->Products->ProductsImages->save($this->Products->ProductsImages->patchEntity($image, ['main' => 1]))) {
            $this->Flash->success(__("Imagem definida como principal"));
        } else {
            $this->Flash->error(__("Não foi possível definir a imagem como principal. Por favor tente novamente."));
        }

        return $this->redirect(['action' => 'edit', $products_id]);
    }

    /**
     * @param $attributes_id
     */
    public function removeAttribute($attributes_id)
    {
        $attribute = $this->Products->ProductsAttributes->get($attributes_id);
        if ($this->Products->ProductsAttributes->hardDelete($attribute)) {
            $json = [
                'status' => true,
                'message' => __('Atributo excluído')
            ];
        } else {
            $json = [
                'status' => false,
                'message' => __('Atributo não foi excluído. Por favor, tente novamente.')
            ];
        }
        $this->set(compact('json'));
    }

    /**
     * @param $products_tabs_id
     */
    public function removeTabContent($products_tabs_id)
    {
        $tab = $this->Products->ProductsTabs->get($products_tabs_id);
        if ($this->Products->ProductsTabs->hardDelete($tab)) {
            $json = [
                'status' => true,
                'message' => __('Aba excluída')
            ];
        } else {
            $json = [
                'status' => false,
                'message' => __('Aba não foi excluída. Por favor, tente novamente.')
            ];
        }
        $this->set(compact('json'));
    }

    /**
     *
     */
    public function status()
    {
        $this->request->allowMethod(['post']);

        $json = [
            'status' => false,
            'message' => 'Produto não encontrado'
        ];

        $status_name = [1 => 'habilitado', 2 => 'desabilitado'];

        $product = $this->Products->get($this->request->getData('product_id'));

        if ($product) {
            if ($this->request->getData('status')) {
                $status = $this->request->getData('status');
            } else {
                $status = $product->status === 1 ? 2 : 1;
            }
            $product = $this->Products->patchEntity($product, ['status' => $status]);
            if ($this->Products->save($product)) {
                $json = [
                    'status' => true,
                    'message' => 'O status do produto <strong>' . $product->name . '</strong> foi alterado'
                ];
            } else {
                $json['message'] = 'O status do produto <strong>' . $product->name . '</strong> não foi alterado. Por favor, tente novamente.';
            }
        }

        $this->set(compact('json'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function update()
    {
        $file = '';
        $this->request->getSession()->delete('update_csv_file');
        $this->request->getSession()->delete('update_csv_header');

        if ($this->request->is('post')) {
            $file = $this->request->getData('file');

            if (!$file) {
                $this->Flash->error(__('Selecione um arquivo para enviar'));
                return $this->redirect(['controller' => 'products', 'action' => 'update']);
            }

            if ($file['error'] > 0) {
                $this->Flash->error(__('Houve um erro ao enviar seu arquivo, tente novamente'));
                return $this->redirect(['controller' => 'products', 'action' => 'update']);
            }

            $file = $this->request->getData('file');

            $data = str_getcsv(file_get_contents($file['tmp_name']), "\n");
            if (!$data) {
                $this->Flash->error(__('O arquivo CSV enviado está vazio. Por favor, selecione outro arquivo e tente novamente.'));
                return $this->redirect(['controller' => 'products', 'action' => 'update']);
            }

            $header = explode(";", $data[0]);
            $file_name = WWW_ROOT . 'csv' . DS . 'importacao_csv_' . Date::now('America/Sao_Paulo')->getTimestamp() . '.csv';
            if (!is_dir(WWW_ROOT . 'csv')) {
                mkdir(WWW_ROOT . 'csv');
            }

            $this->removeAllCsvs();

            if (!move_uploaded_file($file['tmp_name'], $file_name)) {
                $this->Flash->error(__('Não foi possivel salvar seu arquivo temporariamente. Por favor, tente novamente.'));
                return $this->redirect(['controller' => 'products', 'action' => 'update']);
            }
            $this->request->getSession()->write('update_csv_file', $file_name);
            $this->request->getSession()->write('update_csv_header', $header);
            return $this->redirect(['controller' => 'products', 'action' => 'update-map-columns']);
        }
        $this->set(compact('file'));
        $this->set('_serialize', ['file']);
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function updateMapColumns()
    {
        if (!$this->request->getSession()->check('update_csv_header') || !$this->request->getSession()->check('update_csv_file')) {
            $this->Flash->error(__("É preciso enviar um arquivo CSV antes de mapear as colunas"));
            return $this->redirect(['controller' => 'products', 'action' => 'update']);
        }

        if ($this->request->is(['post', 'put'])) {
            $maps = $this->request->getData('map');
            $data = str_getcsv(file_get_contents($this->request->getSession()->read('update_csv_file')), '
            ');
            $fields = [];
            $products_not_found = $products_found = $products_updated = 0;
            unset($data[0]);
            //verifying that the code column has been selected
            if (!in_array('code', $maps)) {
                $this->Flash->error(__('Você deve selecionar o campo Código em alguma coluna para identificação do produto no sistema'));
                return $this->redirect(['controller' => 'products', 'action' => 'update-map-columns']);
            }

            foreach ($data as $line_csv) {
                $item = explode(';', $line_csv);
                foreach ($maps as $key => $map) {
                    if ($map != 'null') {
                        $fields[$map] = $item[trim($key)];
                    }
                }
                $product = $this->Products->find()
                    ->where(['code' => trim($fields['code'])])
                    ->first();

                if ($product) {
                    $products_found++;
                    unset($fields['code']);
                    foreach ($fields as $key => $value) {
                        if (!empty(trim($value))) {
                            switch ($key) {
                                case 'price':
                                    $product->$key = number_format(trim(str_replace(",", ".", str_replace(".", "", $value))), 2, ".", "");
                                    break;
                                case 'stock':
                                    $product->$key = number_format(trim($value), 0);
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                    if ($this->Products->save($product)) {
                        $products_updated++;
                    }
                } else {
                    $products_not_found++;
                }
            }

            $message = 'Produtos não encontrados: ' . $products_not_found . '<br>';
            $message .= 'Produtos encontrados: ' . $products_found . '<br>';
            $message .= 'Produtos atualizados: ' . $products_updated . '<br>';

            $this->Flash->success($message);
            return $this->redirect(['controller' => 'products', 'action' => 'update']);
        }

        $columns = $this->request->getSession()->read('update_csv_header');
        $fields = $this->import_fields;

        $this->set(compact('columns', 'fields'));
        $this->set('_serialize', ['columns', 'fields']);
    }

    /**
     *
     */
    public function deleteVariations()
    {
        $status = false;
        $products_variation = $this->Products->ProductsVariations->get($this->request->getData('products_variations_id'));
        if ($this->Products->ProductsVariations->delete($products_variation)) {
            $status = true;
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }

    /**
     *
     */
    public function deleteVariationsGroups()
    {
        $status = false;
        if ($this->Products->ProductsVariations->deleteAll(['ProductsVariations.variations_groups_id' => $this->request->getData('variations_groups_id')])) {
            $status = true;
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }

    /**
     *
     */
    protected function removeAllCsvs()
    {
        $folder = WWW_ROOT . 'csv';

        if (is_dir($folder)) {
            $files = scandir($folder);
            if ($files) {
                foreach ($files as $file) {
                    if (!in_array($file, ['.', '..'])) {
                        unlink($folder . DS . $file);
                    }
                }
            }
        }
    }

    public function convertImages()
    {
        $productsImages = $this->Products->ProductsImages->find()
            ->where(['id > ' => 120])
            ->toArray();

        $path = ".." . DS . "webroot" . DS . "img" . DS . "files" . DS . "ProductsImages" . DS;
        foreach ($productsImages as $image) {
            $file = $path . $image->image;
            if (file_exists($file)) {
                $info = pathinfo($file);
                $new_name = uniqid() . '.' . $info['extension'];
                if (rename($file, $path . $new_name)) {
                    $tmp = $path . 'thumbnail-' . $new_name;
                    $size = new Box(100, 100);
                    $mode = ImageInterface::THUMBNAIL_OUTBOUND;
                    $imagine = new \Imagine\Gd\Imagine();
                    $imagine->open($path . $new_name)
                        ->thumbnail($size, $mode)
                        ->save($tmp);

                    if ($this->Products->ProductsImages->query()
                        ->update()
                        ->set(['image' => $new_name])
                        ->where(['id' => $image->id])
                        ->execute()) {
                        echo "Imagem alterada";
                    } else {
                        rename($path . $new_name, $file);
                        unlink($path . 'thumbnail-' . $new_name);
                    }
                }
            }
        }
    }

    /**
     * Method to check code the product if is unique
     * This method not render a view
     */
    public function checkCode()
    {
        $status = false;
        if ($this->request->is('post') && $this->request->getData('code')) {
            $product = $this->Products->find()
                ->where([
                    'Products.code' => trim($this->request->getData('code'))
                ])
                ->toArray();
            if ($product) {
                $status = true;
            }
        }
        $this->set(compact('status'));
        $this->set('_serialize', ['status']);
    }
}
