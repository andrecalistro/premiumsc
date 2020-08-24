<?php

namespace Integrators\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Exception\Exception;
use Cake\Http\Client;
use Cake\Network\Exception\UnauthorizedException;
use Cake\ORM\TableRegistry;

/**
 * Nerdpress component
 */
class NerdpressComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function initialize(array $config)
    {
        parent::initialize($config);
        $Stores = TableRegistry::getTableLocator()->get('Admin.Stores');
        $this->setConfig('main', (array)$Stores->findConfig('main'));
    }

    /**
     * @param $path
     * @param $method
     * @param null $data
     * @return bool|mixed
     */
    public function call($path, $method = 'post', $data = null)
    {
        if ($this->getConfig('main.nerdpress_synchronize_customers')) {
            if (!$this->getConfig('main.nerdpress_api_url')) {
                throw new Exception(__('A URL da api com o Nerdpress não foi preenchida ou está incorreta no administrador do Garrula'));
            }
            $client = new Client();
            $data['token'] = 'd7d5b51e8a034f8ee4e41d43432bb5436f2a8b5f227f9e023cc3cc558d2b484c';
            switch ($method) {
                case 'get':
                    $result = $client->get($this->getConfig('main.nerdpress_api_url') . $path);
                    break;
                default:
                    $result = $client->post($this->getConfig('main.nerdpress_api_url') . $path, $data);
                    break;
            }
            return $result->json;
        }
        return false;
    }
}
