<?php

namespace CheckoutV2\Controller\Component;

use Cake\Controller\Component;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use DOMDocument;

/**
 * Correios component
 *
 * @property \Checkout\Model\Table\ShipmentsTable Shipments
 * @property \Checkout\Model\Table\CartsTable Carts
 */
class CorreiosComponent extends Component
{
    use LogTrait;
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $Shipments;
    public $Carts;
    public $session_id;

    private $nCdServices = [];

    private $url = [];

    private $quote_data = [];

    private $destiny_zipcode;
    private $origin_zipcode;

    private $error_message = [];

    public function initialize(array $config)
    {
        parent::initialize($config);

        if (isset($config['session_id'])) {
            $this->setConfig('session_id', $config['session_id']);
        }

        $this->Carts = TableRegistry::getTableLocator()->get('CheckoutV2.Carts');
        $this->Shipments = TableRegistry::getTableLocator()->get('CheckoutV2.Shipments');
        foreach ($this->Shipments->findConfig('correios') as $key => $config) {
            if (preg_match('/services_/', $key)) {
                $key = str_replace('services_', "", $key);
                $this->setConfig('services.' . $key, $key);
            } else {
                $this->setConfig($key, $config);
            }
        }
        $this->setConfig('max_value', 10000);    // máximo valor declarado, em reais
        $this->setConfig('max_height', 105);        // todas as medidas em cm
        $this->setConfig('max_width', 105);
        $this->setConfig('max_length', 105);
        $this->setConfig('min_height', 2);
        $this->setConfig('min_width', 11);
        $this->setConfig('min_length', 16);
        $this->setConfig('max_sum_dimension', 200);    // medida máxima das somas da altura, largura, comprimento
        $this->setConfig('max_weight', 30);    // padrão, em kg
        $this->setConfig('max_weight_pac_sedex', 30);    // em kg
        $this->setConfig('max_weight_esedex', 15);    // em kg
        $this->setConfig('max_weight_sedex10_hoje', 10);    // em kg
        $this->setConfig('min_weight', 0.300);            // em kg
        $this->setConfig('correios', [
            'SEDEX' => '04014',
            '04014' => 'SEDEX',

            'SEDEX a Cobrar' => '40045',
            '40045' => 'SEDEX a Cobrar',

            'SEDEX a Cobrar - contrato' => '40126',
            '40126' => 'SEDEX a Cobrar - contrato',

            'SEDEX 10' => '40215',
            '40215' => 'SEDEX 10',

            'SEDEX Hoje' => '40290',
            '40290' => 'SEDEX Hoje',

            'SEDEX - contrato 1' => '40096',
            '40096' => 'SEDEX - contrato 1',

            'SEDEX - contrato 2' => '40436',
            '40436' => 'SEDEX - contrato 2',

            'SEDEX - contrato 3' => '40444',
            '40444' => 'SEDEX - contrato 3',

            'SEDEX - contrato 4' => '40568',
            '40568' => 'SEDEX - contrato 4',

            'SEDEX - contrato 5' => '40606',
            '40606' => 'SEDEX - contrato 5',

            'PAC' => '04510',
            '04510' => 'PAC',

            'PAC - contrato' => '41068',
            '41068' => 'PAC - contrato',

            'e-SEDEX' => '81019',
            '81019' => 'e-SEDEX',

            'e-SEDEX Prioritario' => '81027',
            '81027' => 'e-SEDEX Prioritario',

            'e-SEDEX Express' => '81035',
            '81035' => 'e-SEDEX Express',

            'e-SEDEX grupo 1' => '81868',
            '81868' => 'e-SEDEX grupo 1',

            'e-SEDEX grupo 2' => '81833',
            '81833' => 'e-SEDEX grupo 2',

            'e-SEDEX grupo 3' => '81850',
            '81850' => 'e-SEDEX grupo 3',

            'SEDEX - contrato 6' => '04162',
            '04162' => 'SEDEX - contrato 6',

            'PAC - contrato 2' => '04677',
            '04677' => 'PAC - contrato 2'
        ]);

        $this->setConfig('image.04510', Router::url('img' . DS . 'shipments' . DS . 'correios' . DS . 'pac.png', true));
        $this->setConfig('image.04014', Router::url('img' . DS . 'shipments' . DS . 'correios' . DS . 'sedex.png', true));

        $this->setConfig('language.text.04510', 'PAC. Entrega em até %s dias úteis');
        $this->setConfig('language.text.04014', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.40215', 'SEDEX 10');
        $this->setConfig('language.text.40045', 'SEDEX a Cobrar. Entrega em até %s dias úteis. Valor retirada: %s');
        $this->setConfig('language.text.81019', 'e-SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.40126', 'SEDEX a Cobrar. Entrega em %s dias úteis. Valor retirada: %s');
        $this->setConfig('language.text.40290', 'SEDEX Hoje');
        $this->setConfig('language.text.40096', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.40436', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.40444', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.40568', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.40606', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.41068', 'PAC. Entrega em até %s dias úteis');
        $this->setConfig('language.text.81027', 'e-SEDEX Prioritário. Entrega em até %s dias úteis');
        $this->setConfig('language.text.81035', 'e-SEDEX Express. Entrega em até %s dias úteis');
        $this->setConfig('language.text.81868', 'e-SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.81833', 'e-SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.81850', 'e-SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.04162', 'SEDEX. Entrega em até %s dias úteis');
        $this->setConfig('language.text.04677', 'PAC. Entrega em até %s dias úteis');
    }

    /**
     * @param $address
     * @param $products
     * @param int $productAdditionalDays
     * @return array
     */
    private function getQuoteInternal($address, $products, $productAdditionalDays = 0)
    {
        $method_data = array();

        if ($this->getConfig('status')) {
            $this->setConfig('product_additional_days', $productAdditionalDays);

            // obtém só a parte numérica do CEP
            $this->setConfig('zipcode_origin', preg_replace("/[^0-9]/", '', $this->getConfig('zipcode_origin')));
            $this->setConfig('zipcode_destination', preg_replace("/[^0-9]/", '', $address['zipcode']));

            $this->nCdServices[$this->getConfig('max_weight_pac_sedex')] = array();
            $this->nCdServices[$this->getConfig('max_weight_esedex')] = array();
            $this->nCdServices[$this->getConfig('max_weight_sedex10_hoje')] = array();

            // serviços sem contrato
            if ($this->getConfig('services.' . $this->getConfig('correios.PAC'))) {
                $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.PAC');
            }
            if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX'))) {
                $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX');
            }
            if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX a Cobrar'))) {
                $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX a Cobrar');
            }
            if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX 10'))) {
                $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX 10');
            }
            if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX Hoje'))) {
                $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX Hoje');
            }

            // serviços com contrato
            if (!empty($this->getConfig('contract_code')) && !empty($this->getConfig('contract_password'))) {

                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX a Cobrar - contrato'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX a Cobrar - contrato');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX - contrato 1'))) {
//                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX - contrato 1');
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = 04162;
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX - contrato 2'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX - contrato 2');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX - contrato 3'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX - contrato 3');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX - contrato 4'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX - contrato 4');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX - contrato 5'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX - contrato 5');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.PAC - contrato'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.PAC - contrato');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX Prioritario'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX Prioritario');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX Express'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX Express');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX grupo 1'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX grupo 1');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX grupo 2'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX grupo 2');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX grupo 3'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX grupo 3');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.e-SEDEX grupo 3'))) {
                    $this->nCdServices[$this->getConfig('max_weight_esedex')][] = $this->getConfig('correios.e-SEDEX grupo 3');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.SEDEX - contrato 6'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.SEDEX - contrato 6');
                }
                if ($this->getConfig('services.' . $this->getConfig('correios.PAC - contrato 2'))) {
                    $this->nCdServices[$this->getConfig('max_weight_pac_sedex')][] = $this->getConfig('correios.PAC - contrato 2');
                }
            }

            foreach ($this->nCdServices as $weight => $services) {
                $this->setConfig('max_weight', $weight);
                //$this->setServicos($servicos); /* talvez nao precise pois ja esta setando no load;

                $boxes = $this->organizeInBoxes($products);

                // file_put_contents('filename.txt', print_r($caixas, true));
                foreach ($boxes as $box) {
                    if ($services) {
                        $this->setQuoteData($box);
                    }
                }
            }
            // ajustes finais
            if ($this->quote_data) {
                $method_data = array(
                    'code' => 'correios',
                    'title' => 'Correios',
                    'quote' => $this->quote_data,
                    'sort_order' => 1,
                    'error' => false
                );
            } else {
                $method_data = array(
                    'code' => 'correios',
                    'title' => "Correios",
                    'quote' => $this->quote_data,
                    'sort_order' => 1,
                    'error' => $this->getConfig('error_message') ? implode('<br />', $this->getConfig('error_message')) : 'Esses produtos não podem ser enviados pelo Correios'
                );
            }
        }
        return $method_data;
    }

    /**
     * 'empacota' os produtos do carrinho em caixas com dimensões e peso dentro dos limites definidos pelos Correios
     *
     * @param $products
     * @return mixed
     */
    private function organizeInBoxes($products)
    {
        $boxes = [];

        foreach ($products as $key => $product) {

            $product_copy = $product;

            // muda-se a quantidade do produto para incrementá-la em cada caixa
            $product_copy['quantity'] = 1;

            if (!isset($product_copy['key'])) {
                $product_copy['key'] = $key;
            }

            // todas as dimensões da caixa serão em cm e kg
            $product_copy['width'] = $product['width'];
            $product_copy['height'] = $product['height'];
            $product_copy['length'] = $product['length'];

            // O peso do produto não é unitário como a dimensão. É multiplicado pela quantidade. Se quisermos o peso unitário, teremos que dividir pela quantidade.
            $product_copy['weight'] = $product['weight'];

            if (isset($product->quantity)) {
                $quantity = $product->quantity;
            } else {
                $quantity = $product['quantity'];
            }

            $box_num = 0;
            for ($i = 1; $i <= $quantity; $i++) {

                // valida as dimensões do produto com as dos Correios
                if ($this->validate($product_copy)) {

                    // cria-se a caixa caso ela não exista.
                    isset($boxes[$box_num]['weight']) ? true : $boxes[$box_num]['weight'] = 0;
                    isset($boxes[$box_num]['height']) ? true : $boxes[$box_num]['height'] = 0;
                    isset($boxes[$box_num]['width']) ? true : $boxes[$box_num]['width'] = 0;
                    isset($boxes[$box_num]['length']) ? true : $boxes[$box_num]['length'] = 0;

                    $new_width = $boxes[$box_num]['width'] + $product_copy['width'];
                    $new_height = $boxes[$box_num]['height'] + $product_copy['height'];
                    $new_length = $boxes[$box_num]['length'] + $product_copy['length'];
                    $new_weight = $boxes[$box_num]['weight'] + $product_copy['weight'];

                    $fit_aside = ($new_width <= $this->getConfig('max_width')) && $this->sumDimensionLimit($boxes, $product_copy, $box_num, 'side');

                    $fit_background = ($new_length <= $this->getConfig('max_length')) && $this->sumDimensionLimit($boxes, $product_copy, $box_num, 'bottom');

                    $fit_top = ($new_height <= $this->getConfig('max_height')) && $this->sumDimensionLimit($boxes, $product_copy, $box_num, 'top');

                    $weight_inside_limit = ($new_weight <= $this->getConfig('max_weight'));

                    // o produto cabe na caixa
                    if (($fit_aside || $fit_background || $fit_top) && $weight_inside_limit) {

                        // já existe o mesmo produto na caixa, assim incrementa-se a sua quantidade
                        if (isset($boxes[$box_num]['products'][$product_copy['key']])) {
                            $boxes[$box_num]['products'][$product_copy['key']]['quantity']++;
                        } // adiciona o novo produto
                        else {
                            $boxes[$box_num]['products'][$product_copy['key']] = $product_copy;
                        }

                        // aumenta-se o peso da caixa
                        $boxes[$box_num]['weight'] += $product_copy['weight'];

                        // ajusta-se as dimensões da nova caixa
                        if ($fit_aside) {
                            $boxes[$box_num]['width'] += $product_copy['width'];

                            // a caixa vai ficar com a altura do maior produto que estiver nela
                            $boxes[$box_num]['height'] = max($boxes[$box_num]['height'], $product_copy['height']);

                            // a caixa vai ficar com o comprimento do maior produto que estiver nela
                            $boxes[$box_num]['length'] = max($boxes[$box_num]['length'], $product_copy['length']);
                        } else if ($fit_background) {
                            $boxes[$box_num]['length'] += $product_copy['length'];

                            // a caixa vai ficar com a altura do maior produto que estiver nela
                            $boxes[$box_num]['height'] = max($boxes[$box_num]['height'], $product_copy['height']);

                            // a caixa vai ficar com a largura do maior produto que estiver nela
                            $boxes[$box_num]['width'] = max($boxes[$box_num]['width'], $product_copy['width']);

                        } else if ($fit_top) {
                            $boxes[$box_num]['height'] += $product_copy['height'];

                            //a caixa vai ficar com a altura do maior produto que estiver nela
                            $boxes[$box_num]['width'] = max($boxes[$box_num]['width'], $product_copy['width']);

                            //a caixa vai ficar com a largura do maior produto que estiver nela
                            $boxes[$box_num]['length'] = max($boxes[$box_num]['length'], $product_copy['length']);
                        }
                    } // tenta adicionar o produto que não coube em uma nova caixa
                    else {
                        $box_num++;
                        $i--;
                    }
                } // produto não tem as dimensões/peso válidos então abandona sem calcular o frete.
                else {
                    $boxes = array();
                    break 2;  // sai dos dois foreach
                }
            }
        }
        return $boxes;
    }

    /**
     * @param $product
     * @return bool
     */
    private function validate($product)
    {
        if (!is_numeric($product['height']) || $product['height'] == 0) {
            $product['height'] = 2;
        }

        if (!is_numeric($product['width']) || $product['width'] == 0) {
            $product['width'] = 11;
        }

        if (!is_numeric($product['length']) || $product['length'] == 0) {
            $product['length'] = 16;
        }

        if (!is_numeric($product['weight']) || $product['weight'] == 0) {
            $product['weight'] = 1;
        }

        if ($product['height'] > $this->getConfig('max_height') || $product['width'] > $this->getConfig('max_width') || $product['length'] > $this->getConfig('max_length')) {
            $this->log(sprintf("Módulo Correios -> produto com dimensões acima do permitido (%sx%sx%s, CxLxA em cm): %s (%sx%sx%s)", $this->getConfig('max_length'), $this->getConfig('max_width'), $this->getConfig('max_height'), $product['name'], $product['comprimento'], $product['largura'], $product['altura']));
            return false;
        }

        $sum_dimensions = $product['length'] + $product['width'] + $product['height'];
        if ($sum_dimensions > $this->getConfig('max_sum_dimension')) {
            $this->log(sprintf("Módulo Correios -> produto com a soma das dimensões acima do limite permitido (%scm): %s (%scm)", $this->getConfig('max_sum_dimension'), $product['name'], $sum_dimensions));
            return false;
        }

        if ($product['weight'] > $this->getConfig('max_weight')) {
            $this->log(sprintf("Módulo Correios -> produto com o peso acima do permitido (%sKg): %s (%sKg)", $this->getConfig('max_weight'), $product['name'], $product['weight']));
            return false;
        }

        return true;
    }

    /**
     * @param $boxes
     * @param $product_copy
     * @param $box_num
     * @param $orientation
     * @return bool
     */
    private function sumDimensionLimit($boxes, $product_copy, $box_num, $orientation)
    {
        if ($orientation == 'side') {
            $width = $boxes[$box_num]['width'] + $product_copy['width'];
            $height = max($boxes[$box_num]['height'], $product_copy['height']);
            $length = max($boxes[$box_num]['length'], $product_copy['length']);
        } elseif ($orientation == 'bottom') {
            $length = $boxes[$box_num]['length'] + $product_copy['length'];
            $height = max($boxes[$box_num]['height'], $product_copy['height']);
            $width = max($boxes[$box_num]['width'], $product_copy['width']);
        } elseif ($orientation == 'top') {
            $height = $boxes[$box_num]['height'] + $product_copy['height'];
            $width = max($boxes[$box_num]['width'], $product_copy['width']);
            $length = max($boxes[$box_num]['length'], $product_copy['length']);
        } else {
            $width = $boxes[$box_num]['width'];
            $height = $boxes[$box_num]['height'];
            $length = $boxes[$box_num]['length'];
        }
        $within_limit = ($width + $height + $length) <= $this->getConfig('max_sum_dimension');

        return $within_limit;
    }

    /**
     * @param $box
     */
    private function setQuoteData($box)
    {
        // obtém o valor total da caixa
        $total_box_price = $this->getTotalBoxPrice($box['products']);
        $total_box_price = ($total_box_price > $this->getConfig('max_value')) ? $this->getConfig('max_value') : $total_box_price;

        list($weight, $height, $width, $length) = $this->adjustDimensions($box);

        // fazendo a chamada ao site dos Correios e obtendo os dados
        $services = $this->getServices($weight, $total_box_price, $length, $width, $height);

        foreach ($services as $service) {
            // o site dos Correios retornou os dados sem erros.
            $valor_frete_sem_adicionais = $service['Valor'] - $service['ValorAvisoRecebimento'] - $service['ValorMaoPropria'] - $service['ValorValorDeclarado'];
            //if($servico['Erro'] == 0 && $valor_frete_sem_adicionais > 0) {
            if ($valor_frete_sem_adicionais > 0) {

                $cost = $service['Valor'] - $service['ValorAvisoRecebimento'] - $service['ValorMaoPropria'] - $service['ValorValorDeclarado'];
                $days = $service['PrazoEntrega'] + $this->getConfig('product_additional_days');

                // o valor do frete para a caixa atual é somado ao valor total já calculado para outras caixas
                if (isset($this->quote_data[$service['Codigo']])) {
                    $cost += $this->quote_data[$service['Codigo']]['cost'];
                }

                // texto a ser exibido para Sedex a Cobrar
                if ($service['Codigo'] == $this->getConfig('correios.SEDEX a Cobrar') || $service['Codigo'] == $this->getConfig('correios.SEDEX a Cobrar - contrato')) {
                    $title = sprintf($this->getConfig('language.text.' . $service['Codigo']), $days, $cost);
                    $text = $cost;
                } else {
                    $title = sprintf($this->getConfig('language.text.' . $service['Codigo']), $days);
                    $text = $cost;
                }

                $title = str_replace(".", " -", $title);

                $this->quote_data[$service['Codigo']] = array(
                    'code' => 'correios.' . $service['Codigo'],
                    'title' => $title,
                    'cost' => $cost,
                    'text' => 'R$ ' . number_format($text, 2, ",", "."),
                    'deadline' => $days,
                    'image' => $this->getConfig('image.' . $service['Codigo'])
                );
            } // grava no log de erros do OpenCart a mensagem de erro retornado pelos Correios
            else {
                $this->error_message[] = $this->getConfig('correios' . $service['Codigo']) . ': ' . $service['MsgErro'];
                $this->log($this->getConfig('correios' . $service['Codigo']) . ': ' . $service['MsgErro']);
            }
        }
    }

    /**
     * @param $products
     * @return int
     */
    private function getTotalBoxPrice($products)
    {
        $total = 0;

        foreach ($products as $product) {
            $total += $product['total_price'];
        }
        if ($total < 18) {
            return 18.5;
        }
        return $total;
    }

    /**
     * @param $box
     * @return array
     */
    private function adjustDimensions($box)
    {
        // a altura não pode ser maior que o comprimento, assim inverte-se as dimensões
        $height = $box['height'];
        $width = $box['width'];
        $length = $box['length'];
        $weight = $box['weight'];

        // se dimensões menores que a permitida, ajusta para o padrão
        if ($height < $this->getConfig('min_height')) {
            $height = $this->getConfig('min_height');
        }
        if ($width < $this->getConfig('min_width')) {
            $width = $this->getConfig('min_width');
        }
        if ($length < $this->getConfig('min_length')) {
            $length = $this->getConfig('min_length');
        }
        if ($weight < $this->getConfig('min_weight')) {
            $weight = $this->getConfig('min_weight');
        }
        if ($height > $length) {
            $temp = $height;
            $height = $length;
            $length = $temp;
        }

        return array($weight, $height, $width, $length);
    }

    /**
     *
     * faz a chamada e lê os dados no arquivo XML retornado pelos Correios
     *
     * @param $weight
     * @param $price
     * @param $length
     * @param $width
     * @param $height
     * @return mixed
     */
    public function getServices($weight, $price, $length, $width, $height)
    {
        $data = array();

        // troca o separador decimal de ponto para vírgula nos dados a serem enviados para os Correios
        $weight = str_replace('.', ',', $weight);

        // Correios parou de aceitar valores com centavos. Que empresa mais amadora...
        //$valor 		= str_replace('.', ',', $valor);
        //$valor 		= number_format((float)$valor, 2, ',' , '.');
        $price > 19 ?: $price = 18.5;

        $length = str_replace('.', ',', $length);
        $width = str_replace('.', ',', $width);
        $height = str_replace('.', ',', $height);

        // ajusta a url de chamada
        $this->setUrl($weight, $price, $length, $width, $height);

        foreach($this->url as $url) {
            // faz a chamada e retorna o xml com os dados
            $xml = $this->getXML($url);

            // lendo o xml
            if ($xml) {
                $dom = new DOMDocument('1.0', 'ISO-8859-1');
                $dom->loadXml($xml);

                $services = $dom->getElementsByTagName('cServico');

                if ($services) {
                    // obtendo o prazo adicional a ser somado com o dos Correios
                    $additional_days = (is_numeric($this->getConfig('additional_days'))) ? $this->getConfig('additional_days') : 0;

                    foreach ($services as $service) {
                        $code = $service->getElementsByTagName('Codigo')->item(0)->nodeValue;

                        if($service->getElementsByTagName('Erro')->item(0)->nodeValue > 0) {
                            $data[$code] = array(
                                "Codigo" => $code,
                                "Valor" => 0,
                                "PrazoEntrega" => 0,
                                "Erro" => $service->getElementsByTagName('Erro')->item(0)->nodeValue,
                                "MsgErro" => $service->getElementsByTagName('MsgErro')->item(0)->nodeValue,
                                "ValorMaoPropria" => 0,
                                "ValorAvisoRecebimento" => 0,
                                "ValorValorDeclarado" => 0
                            );
                            continue;
                        }

                        // Sedex 10 e Sedex Hoje não tem prazo adicional
                        $deadline = ($code == $this->getConfig('correios.SEDEX 10') || $code == $this->getConfig('correios.SEDEX Hoje') ? 0 : $additional_days);

                        $data[$code] = array(
                            "Codigo" => $code,
                            "Valor" => str_replace(',', '.', $service->getElementsByTagName('Valor')->item(0)->nodeValue),
                            "PrazoEntrega" => ($service->getElementsByTagName('PrazoEntrega')->item(0)->nodeValue + $deadline),
                            "Erro" => $service->getElementsByTagName('Erro')->item(0)->nodeValue,
                            "MsgErro" => $service->getElementsByTagName('MsgErro')->item(0)->nodeValue,
                            "ValorMaoPropria" => (isset($service->getElementsByTagName('ValorMaoPropria')->item(0)->nodeValue)) ? str_replace(',', '.', $service->getElementsByTagName('ValorMaoPropria')->item(0)->nodeValue) : 0,
                            "ValorAvisoRecebimento" => (isset($service->getElementsByTagName('ValorAvisoRecebimento')->item(0)->nodeValue)) ? str_replace(',', '.', $service->getElementsByTagName('ValorAvisoRecebimento')->item(0)->nodeValue) : 0,
                            "ValorValorDeclarado" => (isset($service->getElementsByTagName('ValorValorDeclarado')->item(0)->nodeValue)) ? str_replace(',', '.', $service->getElementsByTagName('ValorValorDeclarado')->item(0)->nodeValue) : 0
                        );
                    }
                }
            }
        }
        return $data;
    }

    /**
     *
     * prepara a url de chamada ao site dos Correios
     *
     * @param $weight
     * @param $price
     * @param $length
     * @param $width
     * @param $height
     */
    private function setUrl($weight, $price, $length, $width, $height)
    {
        foreach ($this->getConfig('services') as $service) {
            $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
            //$url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?"; // url alternativa disponibilizada pelos Correios.
            $url .= "nCdEmpresa=" . $this->getConfig('contract_code');
            $url .= "&sDsSenha=" . $this->getConfig('contract_password');
            $url .= "&sCepOrigem=%s";
            $url .= "&sCepDestino=%s";
            $url .= "&nVlPeso=%s";
            $url .= "&nCdFormato=1";
            $url .= "&nVlComprimento=%s";
            $url .= "&nVlLargura=%s";
            $url .= "&nVlAltura=%s";
            $url .= "&sCdMaoPropria=s";
            $url .= "&nVlValorDeclarado=%s";
            $url .= "&sCdAvisoRecebimento=s";
            $url .= "&nCdServico=" . $service;
            $url .= "&nVlDiametro=0";
            $url .= "&StrRetorno=xml";

            $this->url[] = sprintf($url, $this->getConfig('zipcode_origin'), $this->getConfig('zipcode_destination'), $weight, $length, $width, $height, $price);
        }
    }

    /**
     *
     * conecta ao sites dos Correios e obtém o arquivo XML com os dados do frete
     *
     * @param $url
     * @return mixed
     */
    private function getXML($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);

        if (!$result) {
            $this->log(curl_error($ch));
            $this->log('Não foi possível estabelecer conexão com os Correios. Tentando reconectar...');
            $result = curl_exec($ch);

            if ($result) {
                $this->log("Reconexão realizada com sucesso!");
            } else {
                $this->log(curl_error($ch));
                $this->log("Falha na tentativa de reconectar com os Correios. O WebService dos Correios apresenta instabilidade ou está fora do ar.");
            }
        }

        curl_close($ch);

//        $result = str_replace('&amp;lt;sup&amp;gt;&amp;amp;reg;&amp;lt;/sup&amp;gt;', '', $result);
//        $result = str_replace('&amp;lt;sup&amp;gt;&amp;amp;trade;&amp;lt;/sup&amp;gt;', '', $result);
//        $result = str_replace('**', '', $result);
//        $result = str_replace("\r\n", '', $result);
//        $result = str_replace('\"', '"', $result);

        return $result;
    }

    /**
     * @param $address
     * @param null $product
     * @return array
     */
    public function getQuote($address, $product = null, $plan = false)
    {
        if ($product) {
            $products[] = $product;
        } else {
            $products = $this->Carts->find('Products', ['session_id' => $this->getConfig('session_id'), 'shipping_control' => 1]);
        }
        $productsAdditionalDays = $this->Shipments->getProductsAdditionalDays($products);
        return $this->getQuoteInternal($address, $products, $productsAdditionalDays);
    }

    /**
     * @param $address
     * @param $product
     * @return array
     */
    public function getQuotePlan($address, $product)
    {
        return $this->getQuoteInternal($address, [$product]);
    }
}