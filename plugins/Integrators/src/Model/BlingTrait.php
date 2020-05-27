<?php

namespace Integrators\Model;

use Cake\Log\Log;
use SimpleXMLElement;

/**
 * Trait BlingTrait
 * @package Integrators\Model
 */
trait BlingTrait
{
    public $url = 'https://bling.com.br/Api/v2/';
    public $apiKey;

    /**
     * @param array $array
     * @param $context
     * @return mixed
     */
    public function buildXml($array = array(NULL), $context)
    {
        $encoding = 'UTF8';
        $inicialTag = '<' . $context . ' />';
        $xml = new SimpleXMLElement("<?xml version='1.0' encoding='" . $encoding . "' ?>" . $inicialTag);
        foreach ($array as $key1 => $value1) {
            if (is_array($value1) || is_object($value1)) {
                if (!is_numeric($key1))
                    $newNode = $xml->addChild($key1);
                else
                    $newNode = $xml;
                $this->constructXmlNode($value1, $newNode);
            } elseif ($value1 != "")
                $xml->addChild($key1, html_entity_decode($value1));
        }
        return $xml->asXML();
    }

    /**
     * @param $array
     * @param $node
     */
    public function constructXmlNode($array, $node)
    {
        foreach ($array as $key => $value) {
            if (is_array($value) || is_object($value)) {
                if (!is_numeric($key))
                    $newNode = $node->addChild($key);
                else
                    $newNode = $node;
                $this->constructXmlNode($value, $newNode);
            } elseif ($value != "")
                $node->addChild($key, htmlspecialchars($value));
        }
    }

    /**
     * @param $response
     * @return array|object
     */
    public function formatResponse($response)
    {
        $response = json_decode($response);
        $return = [
            'status' => true,
            'message' => '',
            'data' => ''
        ];

        if (isset($response->retorno->erros)) {
            $return['status'] = false;
            foreach ($response->retorno->erros as $key => $error) {
                if (is_string($error)) {
                    Log::error('Bling: ' . $key . ' - ' . $error, 'bling');
                    $return['message'] = $error;
                }
                if (is_object($error) && isset($error->msg)) {
                    Log::error('Bling: ' . $error->cod . ' - ' . $error->msg, 'bling');
                    $return['message'] = $error->msg;
                }
                if (is_object($error) && isset($error->item)) {
                    dd($error);
                }
            }
            return (object)$return;
        }

        if (isset($response->retorno)) {
            $return['data'] = $response->retorno;
        }

        return (object)$return;
    }
}