<?php

namespace Integrators\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Exception\NotFoundException;

/**
 * Class ApiBestShippingComponent for consumer this api https://docs.melhorenvio.com.br/
 * @package Integrators\Controller\Component
 */
class ApiBestShippingComponent extends Component
{
    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        if (!isset($config['environment'])) {
            throw new NotFoundException(__('Environment not configured, needs variable environment'));
        }

        if (!isset($config['token'])) {
            throw new NotFoundException(__('Token not configured, needs variable token'));
        }

        $this->setConfig($config);

        $this->setConfig('endpoint', 'https://melhorenvio.com.br');
        if ($this->getConfig('environment') == 'sandbox') {
            $this->setConfig('endpoint', 'https://sandbox.melhorenvio.com.br');
        }
    }

    /**
     * Calculate shipment, more information https://docs.melhorenvio.com.br/shipment/calculate.html
     *
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function calculate($data)
    {
        return $this->call('post', '/api/v2/me/shipment/calculate', $data, true);
    }

    /**
     * View list of active services in Melhor Envio
     *
     * @return array with the list of services
     * @throws \Exception
     */
    public function getServices()
    {
        return $this->call('get', '/api/v2/me/shipment/services', [], true);
    }

    /**
     * @param $type
     * @param $url
     * @param array $data
     * @param bool $token
     * @param array $headers
     * @return mixed
     * @throws \Exception
     */
    private function call($type, $url, $data = [], $token = true, $headers = [])
    {
        $headers['Accept'] = 'application/json';
        $headers['Content-type'] = 'application/json';
        if ($token) {
            $headers['Authorization'] = 'Bearer ' . $this->getConfig('token');
        }
        $http = new \Cake\Http\Client();

        $url = $this->getConfig('endpoint') . $url;
        switch ($type) {
            case 'post':
                $response = $http->post($url, json_encode($data), ['headers' => $headers]);
                break;
            default:
                $response = $http->get($url, $data, ['headers' => $headers]);
                break;
        }

        if (($status = $response->getStatusCode()) && $status >= 200 && $status < 300) {
            return json_decode($response->getBody());
        } else {
            throw new \Exception('Same error on execute call to Melhor Envio', $response->getStatusCode());
        }
    }
}