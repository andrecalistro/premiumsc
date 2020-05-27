<?php

namespace Admin\Controller;

/**
 * Banners Controller
 *
 * @property \Admin\Model\Table\BannersTable $Banners
 *
 * @method \Admin\Model\Entity\Banner[] paginate($object = null, array $settings = [])
 */
class BannersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel();
        $this->paginate = [
            'contain' => [
                'BannersImages'
            ]
        ];
        $banners = $this->paginate($this->Banners);

        $this->set(compact('banners'));
        $this->set('_serialize', ['banners']);
    }

    /**
     * View method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $banner = $this->Banners->get($id, [
            'contain' => ['BannersImages']
        ]);

        $this->set('banner', $banner);
        $this->set('_serialize', ['banner']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $banner = $this->Banners->newEntity();
        if ($this->request->is('post')) {
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('O banner foi salvo.'));

                return $this->redirect(['action' => 'view', $banner->id]);
            }
            $this->Flash->error(__('O banner não foi salvo. Por favor, tente novamente.'));
        }

        $this->set(compact('banner'));
        $this->set('_serialize', ['banner']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $banner = $this->Banners->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
            if ($this->Banners->save($banner)) {
                $this->Flash->success(__('O banner foi salvo.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O banner não foi salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('banner'));
        $this->set('_serialize', ['banner']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $banner = $this->Banners->get($id);
        if ($this->Banners->delete($banner)) {
            $this->Flash->success(__('O banner foi excluído.'));
        } else {
            $this->Flash->error(__('O banner não foi excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param $banners_images_id
     */
    public function deleteBannerImage($banners_images_id)
    {
        $response = [];
        $this->request->allowMethod(['post', 'delete']);
        $banner_image = $this->Banners->BannersImages->get($banners_images_id);
        if ($this->Banners->BannersImages->delete($banner_image)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }
}
