<?php
namespace Admin\Controller;

use Admin\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Coupons Controller
 *
 * @property \Admin\Model\Table\CouponsTable $Coupons
 *
 * @method \Admin\Model\Entity\Coupon[] paginate($object = null, array $settings = [])
 */
class CouponsController extends AppController
{
	public $coupon_types = [
		'percentage'	=> 'Desconto em porcentagem (%)',
		'cart'			=> 'Desconto fixo de carrinho (R$)',
        'free_shipping' => 'Frete grátis (R$)'
//		'product'		=> 'Desconto fixo de produto (R$)'
	];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $coupons = $this->paginate($this->Coupons);

		$coupon_types = $this->coupon_types;

        $this->set(compact('coupons', 'coupon_types'));
        $this->set('_serialize', ['coupons']);
    }

    /**
     * View method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coupon = $this->Coupons->get($id, [
            'contain' => []
        ]);

		$Products = TableRegistry::getTableLocator()->get('Admin.Products');
		$Categories = TableRegistry::getTableLocator()->get('Admin.Categories');

		$coupon_types = $this->coupon_types;
		$products = $Products->find('list')
			->toArray();
		$categories = $Categories->find('list')
			->toArray();

        $this->set(compact('coupon', 'coupon_types', 'products', 'categories'));
        $this->set('_serialize', ['coupon']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $coupon = $this->Coupons->newEntity();
        if ($this->request->is('post')) {
            $coupon = $this->Coupons->patchEntity($coupon, $this->request->getData());
            $type = $this->request->data('type');
            if($type == 'free_shipping'){
                $coupon['free_shipping'] = 1;
            }
            if ($this->Coupons->save($coupon)) {
                $this->Flash->success(__('O cupom foi salvo!'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O cupom não pode ser salvo. Por favor, tente novamente.'));
        }

        $Products = TableRegistry::getTableLocator()->get('Admin.Products');
        $Categories = TableRegistry::getTableLocator()->get('Admin.Categories');

        $coupon_types = $this->coupon_types;
        $products = $Products->find('list')
			->toArray();
        $categories = $Categories->find('list')
			->toArray();

        $this->set(compact('coupon', 'coupon_types', 'products', 'categories'));
        $this->set('_serialize', ['coupon']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coupon = $this->Coupons->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $coupon = $this->Coupons->patchEntity($coupon, $this->request->getData());
            if ($this->Coupons->save($coupon)) {
                $this->Flash->success(__('O cupom foi salvo!'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O cupom não pode ser salvo. Por favor, tente novamente.'));
        }

        $Products = TableRegistry::getTableLocator()->get('Admin.Products');
        $Categories = TableRegistry::getTableLocator()->get('Admin.Categories');

        $coupon_types = $this->coupon_types;
        $products = $Products->find('list')
			->toArray();
        $categories = $Categories->find('list')
			->toArray();

        $this->set(compact('coupon', 'coupon_types', 'products', 'categories'));
        $this->set('_serialize', ['coupon']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coupon = $this->Coupons->get($id);
        if ($this->Coupons->delete($coupon)) {
            $this->Flash->success(__('O cupom foi apagado!'));
        } else {
            $this->Flash->error(__('O cupom não pode ser apagado. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
