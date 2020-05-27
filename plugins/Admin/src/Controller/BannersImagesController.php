<?php

namespace Admin\Controller;

use Admin\Controller\AppController;

/**
 * BannersImages Controller
 *
 * @property \Admin\Model\Table\BannersImagesTable $BannersImages
 *
 * @method \Admin\Model\Entity\BannersImage[] paginate($object = null, array $settings = [])
 */
class BannersImagesController extends AppController
{
    /**
     * @param $banners_id
     * @return \Cake\Http\Response|null
     */
    public function add($banners_id)
    {
        $bannersImage = $this->BannersImages->newEntity();
        if ($this->request->is('post')) {
            $bannersImage = $this->BannersImages->patchEntity($bannersImage, $this->request->getData());
            if ($this->BannersImages->save($bannersImage)) {
                $this->Flash->success(__('Imagem do banner foi salva.'));

                return $this->redirect(['controller' => 'banners', 'action' => 'view', $banners_id]);
            }
            $this->Flash->error(__('Imagem do banner não foi salva. Por favor, tente novamente.'));
        }
        $statuses = [0 => 'Não publicado', 1 => 'Publicado'];
        $targets = ['_blank' => 'Página em branco/nova página', '_self' => 'Mesma página'];
        $banner = $this->BannersImages->Banners->get($banners_id);
        $this->set(compact('bannersImage', 'statuses', 'targets', 'banners_id', 'banner'));
        $this->set('_serialize', ['bannersImage']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Banners Image id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $bannersImage = $this->BannersImages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bannersImage = $this->BannersImages->patchEntity($bannersImage, $this->request->getData());
            if ($this->BannersImages->save($bannersImage)) {
                $this->Flash->success(__('Imagem do banner foi salva.'));

                return $this->redirect(['controller' => 'banners', 'action' => 'view', $bannersImage->banners_id]);
            }
            $this->Flash->error(__('Imagem do banner não foi salva. Por favor, tente novamente.'));
        }
        $statuses = [0 => 'Não publicado', 1 => 'Publicado'];
        $targets = ['_blank' => 'Página em branco/nova página', '_self' => 'Mesma página'];
        $banner = $this->BannersImages->Banners->get($bannersImage->banners_id);
        $this->set(compact('bannersImage', 'statuses', 'targets', 'banners_id', 'banner'));
        $this->set('_serialize', ['bannersImage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Banners Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bannersImage = $this->BannersImages->get($id);
        if ($this->BannersImages->delete($bannersImage)) {
            $this->Flash->success(__('Imagem foi excluída.'));
        } else {
            $this->Flash->error(__('Imagem não foi excluída. Por favor, tente novamente.'));
        }

        return $this->redirect(['controller' => 'banners', 'action' => 'view', $bannersImage->banners_id]);
    }
}
