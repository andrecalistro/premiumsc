<?php

namespace Integrators\Controller;

use Admin\Model\ConfigTrait;
use Admin\Model\Table\ProductsTable;
use Admin\Model\Table\StoresTable;
use Cake\Database\Exception\MissingExtensionException;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Utility\Security;
use DOMDocument;

/**
 * Class BlingController
 * @package Integrators\Controller
 * @property ProductsTable $Products
 * @property StoresTable $Stores
 */
class GoogleShoppingController extends \Admin\Controller\AppController
{
    public $Stores;
    public $Products;

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setClassName('Integrators.App');
        $this->Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $this->Products = TableRegistry::getTableLocator()->get('Admin.Products');
        $this->Auth->allow(['feed']);
    }

    /**
     *
     */
    public function index()
    {
        $url_xml = Router::url('/integrators/google-shopping/feed.xml', true);
        $feeds = $this->Stores->findByCode('google_shopping');
        $this->set(compact('url_xml', 'feeds'));
    }

    /**
     *
     */
    public function add()
    {
        $Categories = TableRegistry::getTableLocator()->get('Admin.Categories');
        $categories = $Categories->items();

        if ($this->request->is(['post', 'put'])) {
            $categories = $Categories->items([
                'Categories.id IN' => $this->request->getData('categories')
            ]);
            $token = Security::hash(Time::now('America/Sao_Paulo'), 'sha1', true);
            $data = [
                'feed' => [
                    'categories' => ($categories) ? $categories : false,
                    'token' => $token,
                    'url' => Router::url('/integrators/google-shopping/feed/' . $token . '.xml', true)
                ]
            ];
            $feed = $this->Stores->prepareSave($data, 'google_shopping', false);
            $feed = $this->Stores->newEntity($feed[0]);
            if ($this->Stores->save($feed)) {
                $this->Flash->success(__('Feed cadastrado com sucesso.'));
                return $this->redirect(['controller' => 'google-shopping', 'action' => 'index', 'plugin' => 'integrators']);
            }
            $this->Flash->error(__('Ocorreu um problema ao cadastrar o feed. Por favor, tente novamente.'));
        }

        $this->set(compact('categories'));
    }

    /**
     * @param null $token
     */
    public function feed($token = null)
    {
        if (!$this->request->getParam('_ext') || $this->request->getParam('_ext') != 'xml') {
            throw new MissingExtensionException('Invalid extension. The url must contain .xml in the end.');
        }

        $feed_products = [];

        $products = $this->Products->find()
            ->contain([
                'ProductsVariations',
                'ProductsImages' => function ($q) {
                    return $q->order(['ProductsImages.main' => 'DESC', 'ProductsImages.id' => 'ASC']);
                },
                'Categories'
            ])
            ->where([
                'Products.status' => 1,
                'Products.price >' => 0,
                'Products.stock >' => 0,
            ]);

        if ($token) {
            $feeds = $this->Stores->findByCode('google_shopping');
            $categories = [];
            if ($feeds) {
                foreach ($feeds as $feed) {
                    if ($feed['value']->token === $token) {
                        $categories = array_keys((array)$feed['value']->categories);
                    }
                }
                $products->matching('Categories', function ($q) use ($categories) {
                    return $q->where(['Categories.id IN' => $categories]);
                });
            }
        }
        $products = $products->toArray();

        if ($products) {
            foreach ($products as $product) {
                //CREATE EMPTY ARRAY FOR GOOGLE-FRIENDLY INFO
                $gf_product = [];

                //FLAGS FOR LATER
                $gf_product['is_clothing'] = 0; //set True or False, depending on whether product is clothing
                $gf_product['is_on_sale'] = true; //set True or False depending on whether product is on sale

                //feed attributes
                $gf_product['g:id'] = $product->id;
                $gf_product['g:sku'] = $product->code;
                $gf_product['g:title'] = $product->name;
                $gf_product['g:description'] = empty($product->resume) ? $product->seo_description : $product->resume;
                $gf_product['g:link'] = Router::url('/produto/' . $product->seo_url . '/' . $product->id, true);
                $gf_product['g:image_link'] = $product->main_image;
                $gf_product['g:availability'] = $product->stock > 0 ? 'in stock' : 'out of stock';
                $gf_product['g:price'] = $product->price . ' BRL';
                $gf_product['g:google_product_category'] = 371;
                $gf_product['g:brand'] = '';
                $gf_product['g:gtin'] = $product->ean;
                $gf_product['g:mpn'] = '';
                if (($gf_product['g:gtin'] == "") && ($gf_product['g:mpn'] == "")) {
                    $gf_product['g:identifier_exists'] = "no";
                };
                $gf_product['g:condition'] = $product->condition_product == 1 ? 'used' : 'new'; //must be NEW or USED
                //remove this IF block if you don't sell any clothing
//                if ($gf_product['is_clothing']) {
//                    $gf_product['g:age_group'] = $product['age_group']; //newborn/infant/toddle/kids/adult
//                    $gf_product['g:color'] = $product['color'];
//                    $gf_product['g:gender'] = $product['gender'];
//                    $gf_product['g:size'] = $product['size'];
//                }
                if ($gf_product['is_on_sale']) {
                    $gf_product['g:sale_price'] = $product->price . ' BRL';
                    $gf_product['g:sale_price_effective_date'] = Date::now('America/Sao_Paulo')->format('Y-m-d') . " / " . Date::now('America/Sao_Paulo')->addYears(2)->format('Y-m-d');
                }

                $feed_products[] = $gf_product;
            }
        }
        $doc = new DOMDocument('1.0', 'UTF-8');

        $xmlRoot = $doc->createElement("rss");
        $xmlRoot = $doc->appendChild($xmlRoot);
        $xmlRoot->setAttribute('version', '2.0');
        $xmlRoot->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', "http://base.google.com/ns/1.0");

        $store = $this->Stores->findConfig('store');

        $channelNode = $xmlRoot->appendChild($doc->createElement('channel'));
        $channelNode->appendChild($doc->createElement('title', $store->name));
        $channelNode->appendChild($doc->createElement('link', Router::url('', true)));

        if ($feed_products) {
            foreach ($feed_products as $product) {
                $itemNode = $channelNode->appendChild($doc->createElement('item'));
                foreach ($product as $key => $value) {
                    if ($value != "") {
                        if (is_array($product[$key])) {
                            $subItemNode = $itemNode->appendChild($doc->createElement($key));
                            foreach ($product[$key] as $key2 => $value2) {
                                $subItemNode->appendChild($doc->createElement($key2))->appendChild($doc->createTextNode($value2));
                            }
                        } else {
                            $itemNode->appendChild($doc->createElement($key))->appendChild($doc->createTextNode($value));
                        }

                    } else {

                        $itemNode->appendChild($doc->createElement($key));
                    }

                }
            }
        }

        $xmlString = $doc->saveXML();

        $this->set(compact('xmlString'));
        $this->set('_serialize', ['xmlString']);
    }

    /**
     * @param $id
     * @return \Cake\Http\Response|null
     */
    public function delete($id)
    {
        $feed = $this->Stores->get($id);
        if ($this->Stores->delete($feed)) {
            $this->Flash->success(__('Feed excluído com sucesso.'));

        } else {
            $this->Flash->error(__('Não foi possível excluir seu feed. Por favor, tente novamente'));
        }
        return $this->redirect(['controller' => 'google-shopping', 'action' => 'index', 'plugin' => 'integrators']);
    }
}