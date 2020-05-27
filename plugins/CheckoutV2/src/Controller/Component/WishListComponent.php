<?php

namespace CheckoutV2\Controller\Component;

use Admin\Model\Table\StoresTable;
use Admin\Model\Table\WishListsTable;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class WishListComponent extends Component
{
    /** @var WishListsTable */
    public $WishLists;

    /** @var StoresTable */
    public $Stores;

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->WishLists = TableRegistry::getTableLocator()->get('Admin.WishLists');
        $this->Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
    }

    /**
     * @param $customer
     * @return \Admin\Model\Entity\WishList|array|bool|\Cake\Datasource\EntityInterface|null
     * @throws \Exception
     */
    public function addProductsSession($customer)
    {
        if (!$this->Stores->getByKeyword('wish_list_status')) {
            return false;
        }

        $customerId = $customer['id'];
        $session = $this->getController()->request->getSession();

        if (!$session->check('wish-list')) {
            return false;
        }

        $wishListProducts = $session->read('wish-list');

        $wishList = $this->getLastWishListActive($customerId);

        if (!$wishList) {
            $wishList = $this->createNewWishList($customerId, $customer['name']);
        }

        foreach ($wishListProducts as $wishListProduct) {
            $this->addProductWishList($wishList->id, $wishListProduct, $customerId);
        }

        $session->delete('wish-list');

        return $wishList;
    }

    /**
     * @param $customerId
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    public function getLastWishListActive($customerId)
    {
        $wishList = $this->WishLists->find()
            ->where([
                'customers_id' => $customerId,
                'wish_list_statuses_id' => 1
            ])
            ->order(['id' => 'DESC'])
            ->limit(1)
            ->first();
        return $wishList;
    }

    /**
     * @param $customerId
     * @param $customerName
     * @param null $productId
     * @return \Admin\Model\Entity\WishList|bool
     * @throws \Exception
     */
    public function createNewWishList($customerId, $customerName, $productId = null)
    {
        $validate = new \DateTime('now', (new \DateTimeZone('America/Sao_Paulo')));
        $validate->add(\DateInterval::createFromDateString('+90 days'));

        $wishListData = [
            'customers_id' => $customerId,
            'validate' => $validate,
            'name' => $this->createAutomaticWishListName($customerName),
            'wish_list_statuses_id' => 1
        ];

        $wishListData = $this->WishLists->newEntity($wishListData);
        $wishList = $this->WishLists->save($wishListData);

        if ($productId) {
            $this->addProductWishList($productId, $wishList->id, $customerId);
        }

        return $wishList;
    }

    /**
     * @param $userName
     * @return string
     */
    public function createAutomaticWishListName($userName)
    {
        return sprintf('Lista de desejos de %s', $userName);
    }

    /**
     * @param $wishListId
     * @param $productId
     * @param $customerId
     * @return int|mixed
     */
    public function addProductWishList($wishListId, $productId, $customerId)
    {
        $wishListProduct = $this->WishLists->WishListProducts->find()
            ->where([
                'products_id' => $productId,
                'wish_lists_id' => $wishListId
            ])
            ->first();

        if ($wishListProduct) {
            return $wishListProduct->id;
        }

        $wishListProductData = [
            'customers_id' => $customerId,
            'products_id' => $productId,
            'wish_lists_id' => $wishListId,
            'wish_list_product_statuses_id' => 1
        ];

        $wishListProductData = $this->WishLists->WishListProducts->newEntity($wishListProductData);
        $this->WishLists->WishListProducts->save($wishListProductData);

        return $wishListProductData->id;
    }
}