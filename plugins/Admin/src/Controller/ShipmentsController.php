<?php

namespace Admin\Controller;

/**
 * Shipments Controller
 *
 * @property \Admin\Model\Table\ShipmentsTable $Shipments
 */
class ShipmentsController extends AppController
{
    public function index()
    {
        $shipments = [
            [
                'name' => 'Correios',
                'status' => $this->Shipments->getConfig('correios_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'correios'
            ],
            [
                'name' => 'Frete Grátis',
                'status' => $this->Shipments->getConfig('free_shipping_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'free_shipping'
            ],
            [
                'name' => 'Motoboy',
                'status' => $this->Shipments->getConfig('motoboy_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'motoboy'
            ],
            [
                'name' => 'Retirada na loja',
                'status' => $this->Shipments->getConfig('removal_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'removal'
            ],
            [
                'name' => 'Rodonaves',
                'status' => $this->Shipments->getConfig('rodonaves_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'rodonaves'
            ],
            [
                'name' => 'Braspress',
                'status' => $this->Shipments->getConfig('braspress_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'braspress'
            ],
            [
                'name' => 'Frenet',
                'status' => $this->Shipments->getConfig('frenet_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'frenet'
            ],
            [
                'name' => 'Melhor Envio',
                'status' => $this->Shipments->getConfig('melhor_envio_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'best-shipping'
            ],
            [
                'name' => 'Impresso',
                'status' => $this->Shipments->getConfig('printed_status') ? '<span class="label label-success">Habilitado</span>' : '<span class="label label-danger">Desabilitado</span>',
                'action' => 'printed'
            ]
        ];
        $this->set(compact('shipments'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function correios()
    {
        $result = $this->Shipments->findConfig('correios');
        $entity = (object)[
            'zipcode_origin' => '',
            'additional_days' => '',
            'status' => 0,
            'contract_code' => '',
            'contract_password' => '',
            'services_04014' => '',
            'services_40045' => '',
            'services_40215' => '',
            'services_40169' => '',
            'services_40290' => '',
            'services_04510' => '',
            'services_41262' => '',
            'services_40126' => '',
            'services_40096' => '',
            'services_40436' => '',
            'services_40444' => '',
            'services_40568' => '',
            'services_40606' => '',
            'services_41068' => '',
            'services_41300' => '',
            'services_81019' => '',
            'services_81027' => '',
            'services_81035' => '',
            'services_81868' => '',
            'services_81833' => '',
            'services_81850' => '',
            'services_04162' => '',
            'services_04677' => ''
        ];
        $correios = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'correios');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configuração dos Correios foi salva."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }
        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $services = [
            'services_04014' => 'SEDEX',
            'services_40045' => 'SEDEX Pagamento na Entrega',
            'services_40215' => 'SEDEX 10',
            'services_40169' => 'SEDEX 12',
            'services_40290' => 'SEDEX Hoje',
            'services_04510' => 'PAC',
            'services_41262' => 'PAC Pagamento na Entrega',
            'services_40126' => 'SEDEX Pagamento na Entrega - com contrato',
            'services_40096' => 'SEDEX - com contrato (40096)',
            'services_40436' => 'SEDEX - com contrato (40436)',
            'services_40444' => 'SEDEX - com contrato (40444)',
            'services_40568' => 'SEDEX - com contrato (40568)',
            'services_40606' => 'SEDEX - com contrato (40606)',
            'services_41068' => 'PAC - com contrato (41068)',
            'services_41300' => 'PAC Grandes Formatos - com contrato',
            'services_81019' => 'e-SEDEX - com contrato',
            'services_81027' => 'e-SEDEX Prioritário - com contrato',
            'services_81035' => 'e-SEDEX Express - com contrato',
            'services_81868' => '(Grupo 1) e-SEDEX - com contrato',
            'services_81833' => '(Grupo 2) e-SEDEX - com contrato',
            'services_81850' => '(Grupo 3) e-SEDEX - com contrato',
            'services_04162' => 'SEDEX - com contrato (04162)',
            'services_04677' => 'PAC - com contrato (04677)'
        ];
        $this->set(compact('statuses', 'services', 'correios'));
        $this->set('_serialize', 'correios');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function freeShipping()
    {
        $result = $this->Shipments->findConfig('free_shipping');
        $entity = (object)[
            'status' => 0,
            'interval' => []
        ];
        $freeShipping = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'free_shipping');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações de Frete Grátis foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'freeShipping', 'states'));
        $this->set('_serialize', 'freeShipping');
    }

    public function motoboy()
    {
        $result = $this->Shipments->findConfig('motoboy');
        $entity = (object)[
            'status' => 0,
            'interval' => []
        ];
        $motoboy = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'motoboy');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações de Motoboy foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'motoboy', 'states'));
        $this->set('_serialize', 'motoboy');
    }

    public function removal()
    {
        $result = $this->Shipments->findConfig('removal');
        $entity = (object)[
            'status' => 0,
            'interval' => []
        ];
        $removal = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'removal');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações de Retirada na loja foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'removal', 'states'));
        $this->set('_serialize', 'removal');
    }

    public function getCepInterval()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://www.buscacep.correios.com.br/sistemas/buscacep/resultadoBuscaFaixaCEP.cfm",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"UF\"\r\n\r\nPR\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"Localidade\"\r\n\r\ncuritiba\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
                "postman-token: 8041c1e5-0af8-ad3f-4e8b-d6d3f9740453"
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $this->set([
                'response' => $response,
                '_serialize' => ['response']
            ]);
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function rodonaves()
    {
        $result = $this->Shipments->findConfig('rodonaves');
        $entity = (object)[
            'status' => 0,
            'zipcode' => '',
            'additional_days' => '',
            'user' => '',
            'password' => ''
        ];
        $rodonaves = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'rodonaves');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações da Rodonaves foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'rodonaves', 'states'));
        $this->set('_serialize', 'rodonaves');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function braspress()
    {
        $result = $this->Shipments->findConfig('braspress');
        $entity = (object)[
            'status' => 0,
            'cnpj' => '',
            'zipcode' => '',
            'additional_days' => ''
        ];

        $braspress = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'braspress');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações da Braspress foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'braspress', 'states'));
        $this->set('_serialize', 'braspress');
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function frenet()
    {
        $result = $this->Shipments->findConfig('frenet');
        $entity = (object)[
            'status' => 0,
            'zipcode' => '',
            'additional_days' => '',
            'key' => '',
            'password' => '',
            'token' => ''

        ];

        $frenet = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'frenet');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações da Frenet foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'frenet'));
        $this->set('_serialize', 'frenet');
    }

    /**
     * @return \Cake\Http\Response|null
     * @throws \Exception
     */
    public function bestShipping()
    {
        $result = $this->Shipments->findConfig('melhor_envio');
        $entity = (object)[
            'status' => 0,
            'zipcode' => '',
            'environment' => 'sandbox',
            'additional_days' => '',
            'token' => '',
            'services' => ''
        ];
        $bestShipping = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'melhor_envio');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações do Melhor Envio foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $this->loadComponent('Integrators.ApiBestShipping', (array)$bestShipping);
        $servicesList = $this->ApiBestShipping->getServices();
        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $environments = ['production' => 'Produção', 'sandbox' => 'Sandbox'];
        $this->set(compact('statuses', 'bestShipping', 'environments', 'servicesList'));
        $this->set('_serialize', 'bestShipping');
    }

    public function printed()
    {
        $result = $this->Shipments->findConfig('printed');
        $entity = (object)[
            'status' => 0,
            'interval' => []
        ];
        $printed = $this->Shipments->mapFindConfig($entity, $result);
        if ($this->request->is(['post'])) {
            $data = $this->Shipments->prepareSave($this->request->getData(), 'printed');
            $entities = $this->Shipments->newEntities($data);
            if ($this->Shipments->saveMany($entities)) {
                $this->Flash->success(__("Configurações de Impresso foram salvas."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("As configurações não foram salvas. Por favor, tente novamente."));
            }
        }

        $statuses = [0 => 'Desabilitado', 1 => 'Habilitado'];
        $this->set(compact('statuses', 'printed', 'states'));
        $this->set('_serialize', 'printed');
    }
}