<?php
defined('_VALID_CALL') or die('Direct Access is not allowed.');

class xt_correios
{

    public $product;

    CONST URL_WEBSERVICE_CORREIOS = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

    CONST AVISO_RECEBIMENTO_DEFAULT = 'N';

    CONST MAO_PROPRIA_DEFAULT = 'N';

    CONST RRETORNO_DEFAULT = 'XML';

    CONST FORMATO_DEFAULT = 1;

    CONST MINIMUM_HEIGHT = 0.02;

    CONST MINIMUN_WIDTH = 0.11;

    CONST MINIMUN_LENGTH = 0.16;

    CONST MAX_HEIGHT = 1.05;

    CONST MAX_WIDTH = 1.05;

    CONST MAX_LENGTH = 1.05;

    public function database()
    {
        global $language, $db;

        return $db;
    }

    function setPosition($position)
    {
        $this->position = $position;
    }

    function _getParams()
    {
        $params = array();
        include ("admin/send-form.php");
        exit();
        return $params;
    }

    function _get($ID = 0)
    {
        $obj = new stdClass();
        return $obj;
    }

    function _set($data, $set_type = 'edit')
    {
        $obj = new stdClass();
        return $obj;
    }

    function _unset($id = 0)
    {}

    public function test()
    {
        return 'teste';
    }

    function _getCode()
    {
        // if ($_GET['page']=='checkout' && $_GET['page_action']=='success' && XT_CORREIOS_ACTIVATE=='true') {
        if ($_GET['page'] == 'checkout' && $_GET['page_action'] == 'success') {
            global $success_order;
            echo $this->_getEcommerceCode();
        }
    }

    function _getEcommerceCode()
    {
        global $success_order;

        if (! is_object($success_order))
            return false;
        $total_net = 0;
        foreach ($success_order->order_products as $key => $arr) {
            $total_net += $arr['products_final_price']['plain_otax'];
        }
        $output = '';
        $output = '<script language="JavaScript" type="text/javascript">
<!-- wein.cc conversion code V2.2
var value=' . $total_net . '; //Nettoumsatz
var merchantid=' . xt_correios . '; //Ihre Kundennummer
var orderid=' . $success_order->order_data['orders_id'] . '; //Bestellnummer Ihres Shopsystems, optional
var cur=\'eur\'; //Waehrung: aud, cad, chf, eur, gbp, jpy, usd
var thispage=escape(document.URL);
//-->
</script>
<script language="JavaScript" src="//www.ebizoptimizer.com/conversion/script.js">
</script>
<noscript>
<img src="//www.ebizoptimizer.com/conversion/tracking/' . xt_correios . '/?value=' . $total_net . '&orderid=' . $success_order->order_data['orders_id'] . '&cur=eur" height=1 width=1 border=0 alt="">
</noscript>';

        return $output;
    }

    public function getUserCorreios()
    {
        try {

            $db = $this->database();
            $user = $db->Execute("SELECT * FROM " . DB_PREFIX . "_user_correios");
            if ($user->RecordCount() > 0) {
                $userArray = array(
                    'nCdEmpresa' => $user->fields['nCdEmpresa'],
                    'sDsSenha' => $user->fields['sDsSenha'],
                    'zipCode' => $user->fields['cep_origem']
                );
            }

            return $userArray;
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     */
    public function getServiceCorreios()
    {
        try {

            $db = $this->database();
            $service = $db->Execute("SELECT * FROM " . DB_PREFIX . "_services_correios");

            if ($service->RecordCount() > 0) {
                while (! $service->EOF) {
                    $serviceArray[] = array(
                        'code_service' => $service->fields['code_service'],
                        'description' => $service->fields['description'],
                        'active' => $service->fields['active']
                    );
                    $service->MoveNext();
                }
            }

            return $serviceArray;
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     */
    public function getDescriptionService($code_service)
    {
        try {

            $db = $this->database();
            $serviceDb = $db->Execute("SELECT * FROM " . DB_PREFIX . "_services_correios WHERE CODE_SERVICE = " . $code_service . "");

            if ($serviceDb->RecordCount() > 0) {

                $description = $serviceDb->fields['description'];
            }

            return $description;
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     */
    public function codeServiceCorreios()
    {
        try {
            $codeService = '';
            for ($i = 0; $i < count($getServiceCorreios = $this->getServiceCorreios()); ++ $i) {

                if ($getServiceCorreios[$i]['active'] == 'S') {

                    $codeService .= "" . $getServiceCorreios[$i]['code_service'] . ",";
                }
            }

            if (substr($codeService, - 1) == ',') {

                $codeService = substr($codeService, 0, - 1);
            }

            return $codeService;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Function Get Size of products to correios.
     */
    public function getSizeProduct($productID)
    {
        try {
            if (! empty($productID)) {
                // # The IF is for 1 product and the else is for more products.
                if (count($productID) == 1) {

                    $db = $this->database();
                    $productQuery = $db->Execute("SELECT * FROM " . DB_PREFIX . "_products WHERE PRODUCTS_ID = " . $productID[0]->product_id . "");

                    if ($productQuery->RecordCount() > 0) {
                        // # if is For 1 quantity and the else is for multiple quantity
                        if ($productID[0]->products_quantity == 1) {

                            $this->product = array(
                                'height' => $productQuery->fields['height'],
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $productQuery->fields['products_weight'],
                                'price' => number_format($productQuery->fields['products_price'], 2, ',', '.')
                            );
                        } else {
                            $this->product = array(
                                'height' => number_format($productID[0]->products_quantity * $productQuery->fields['height'], 2, '.', ''),
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $productID[0]->products_quantity * $productQuery->fields['products_weight'],
                                'price' => number_format($productID[0]->products_quantity * $productQuery->fields['products_price'], 2, ',', '.')
                            );
                        }
                    }
                } else {

                    $db = $this->database();
                    foreach ($productID as $value) {

                        $productQuery = $db->Execute("SELECT * FROM " . DB_PREFIX . "_products WHERE PRODUCTS_ID = " . $value->product_id . "");

                        if ($value->products_quantity == 1) {
                            $produto[] = array(
                                'height' => $productQuery->fields['height'],
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $productQuery->fields['products_weight'],
                                'price' => number_format($productQuery->fields['products_price'], 2, ',', '.')
                            );
                        } else {
                            $produto[] = array(
                                'height' => number_format($value->products_quantity * $productQuery->fields['height'], 2, '.', ''),
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $value->products_quantity * $productQuery->fields['products_weight'],
                                'price' => number_format($value->products_quantity * $productQuery->fields['products_price'], 2, ',', '.')
                            );
                        }

                        $produtoList = $produto;
                    }

                    $height = 0.00;
                    $weight = 0.00;
                    $price = 0.00;

                    foreach ($produtoList as $num) {

                        if ($num['width'] == 0.00) {
                            $this->product = array(
                                'height' => 0.00,
                                'length' => 0.00,
                                'width' => 0.00,
                                'weight' => 0.00,
                                'price' => 0.00
                            );
                        } else {
                            $widest[] = $num['width']; // Monta Array Largura
                        }
                        if ($num['length'] == 0.00) {
                            $this->product = array(
                                'height' => 0.00,
                                'length' => 0.00,
                                'width' => 0.00,
                                'weight' => 0.00,
                                'price' => 0.00
                            );
                        } else {
                            $longerLength[] = $num['length'];
                        }
                        if ($num['height'] == 0.00) {
                            $this->product = array(
                                'height' => 0.00,
                                'length' => 0.00,
                                'width' => 0.00,
                                'weight' => 0.00,
                                'price' => 0.00
                            );
                        } else {
                            $heightList[] = $num['height'];
                        }
                        if ($num['weight'] == 0.00) {
                            $this->product = array(
                                'height' => 0.00,
                                'length' => 0.00,
                                'width' => 0.00,
                                'weight' => 0.00,
                                'price' => 0.00
                            );
                        } else {
                            $weightList[] = $num['weight']; // Soma Peso
                        }

                        $priceList[] = $num['price']; // Soma Preços
                    }

                    $width = max($widest);
                    $length = max($longerLength);
                    $weight = array_sum($weightList);
                    $height = array_sum($heightList);
                    $price = array_sum($priceList);

                    $this->product = array(
                        'height' => number_format($height, 2, '.', ''),
                        'length' => number_format($length, 2, '.', ''),
                        'width' => number_format($width, 2, '.', ''),
                        'weight' => $weight,
                        'price' => number_format($price, 2, ',', '.')
                    );
                }
                return $this->product;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Function Get Size of products to correios.
     */
    public function getSizeProductCheckout($productID)
    {
        try {

            $db = $this->database();
            if (! empty($productID)) {
                foreach ($productID as $productArray) {
                    $product[] = array(
                        'product_id' => (int) $productArray['products_id'],
                        'products_quantity' => $productArray['products_quantity']
                    );
                }

                $productListCart = $product;

                // # The IF is for 1 product and the else is for more products.
                if (count($productListCart) == 1) {
                    $productQuery = $db->Execute("SELECT * FROM " . DB_PREFIX . "_products WHERE PRODUCTS_ID = " . $productListCart[0]['product_id'] . "");
                    if ($productQuery->RecordCount() > 0) {
                        // # if is For 1 quantity and the else is for multiple quantity
                        if ($productListCart[0]['products_quantity'] == 1) {
                            $this->product = array(
                                'height' => $productQuery->fields['height'],
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $productQuery->fields['products_weight'],
                                'price' => number_format($productQuery->fields['products_price'], 2, ',', '.')
                            );
                        } else {
                            $this->product = array(
                                'height' => number_format($productListCart[0]['products_quantity'] * $productQuery->fields['height'], 2, '.', ''),
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $productListCart[0]['products_quantity'] * $productQuery->fields['products_weight'],
                                'price' => number_format($productListCart[0]['products_quantity'] * $productQuery->fields['products_price'], 2, ',', '.')
                            );
                        }
                    }
                } else {

                    foreach ($productListCart as $value) {
                        $productQuery = $db->Execute("SELECT * FROM " . DB_PREFIX . "_products WHERE PRODUCTS_ID = " . $value['product_id'] . "");
                        if ($value['products_quantity'] == 1) {
                            $produto[] = array(
                                'height' => $productQuery->fields['height'],
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $productQuery->fields['products_weight'],
                                'price' => number_format($productQuery->fields['products_price'], 2, ',', '.')
                            );
                        } else {
                            $produto[] = array(
                                'height' => number_format($value['products_quantity'] * $productQuery->fields['height'], 2, '.', ''),
                                'length' => $productQuery->fields['length'],
                                'width' => $productQuery->fields['width'],
                                'weight' => $value['products_quantity'] * $productQuery->fields['products_weight'],
                                'price' => number_format($value['products_quantity'] * $productQuery->fields['products_price'], 2, ',', '.')
                            );
                        }
                        $produtoList = $produto;
                    }

                    $height = 0.00;
                    $weight = 0.00;
                    $price = 0.00;
                    foreach ($produtoList as $num) {

                        if ($num['width'] == 0.00) {
                            $this->product = array(
                                'height' => self::MINIMUM_HEIGHT,
                                'length' => self::MINIMUN_LENGTH,
                                'width' => self::MINIMUN_WIDTH,
                                'weight' => 0.500,
                                'price' => 0.00
                            );
                        } else {
                            $widest[] = $num['width']; // Monta Array Largura
                        }
                        if ($num['length'] == 0.00) {
                            $this->product = array(
                                'height' => self::MINIMUM_HEIGHT,
                                'length' => self::MINIMUN_LENGTH,
                                'width' => self::MINIMUN_WIDTH,
                                'weight' => 0.500,
                                'price' => 0.00
                            );
                        } else {
                            $longerLength[] = $num['length'];
                        }
                        if ($num['height'] == 0.00) {
                            $this->product = array(
                                'height' => self::MINIMUM_HEIGHT,
                                'length' => self::MINIMUN_LENGTH,
                                'width' => self::MINIMUN_WIDTH,
                                'weight' => 0.500,
                                'price' => 0.00
                            );
                        } else {
                            $heightList[] = $num['height'];
                        }
                        if ($num['weight'] == 0.00) {
                            $this->product = array(
                                'height' => self::MINIMUM_HEIGHT,
                                'length' => self::MINIMUN_LENGTH,
                                'width' => self::MINIMUN_WIDTH,
                                'weight' => 0.500,
                                'price' => 0.00
                            );
                        } else {
                            $weightList[] = $num['weight']; // Soma Peso
                        }
                        $priceList[] = $num['price']; // Soma Preços
                    }

                    $width = max($widest);
                    $length = max($longerLength);
                    $weight = array_sum($weightList);
                    $height = array_sum($heightList);
                    $price = array_sum($priceList);

                    $this->product = array(
                        'height' => number_format($height, 2, '.', ''),
                        'length' => number_format($length, 2, '.', ''),
                        'width' => number_format($width, 2, '.', ''),
                        'weight' => $weight,
                        'price' => number_format($price, 2, ',', '.')
                    );
                }

                return $this->product;
            } else {

                return false;
            }
        } catch (Exception $e) {

            return false;
        }
    }

    /**
     */
    public function correiosConsultExpected($callCorreios)
    {
        $data = array();
        try {
            $getUserCorreios = $this->getUserCorreios();

            if (is_array($getUserCorreios)) {

                $data['nCdEmpresa'] = $getUserCorreios['nCdEmpresa'];
                $data['sex'] = $getUserCorreios['sDsSenha'];

                if (empty($getUserCorreios['zipCode'])) {
                    return TEXT_SERVICE_UNAVAILABLE;
                }

                $data['sCepOrigem'] = $getUserCorreios['zipCode'];
            }

            $data['nCdServico'] = $this->codeServiceCorreios();
            $data['sCepDestino'] = $callCorreios['zipCode'];

            /**
             * Validate Height correios minimun and max size before convert float to string.
             */
            if ($this->validateHeight($callCorreios['package']['height']) == false) {
                return TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE;
            } else {
                $data['nVlAltura'] = $this->validateHeight($callCorreios['package']['height']);
            }

            /**
             * Validate Width correios minimun and max size before convert float to string.
             */
            if ($this->validateWidth($callCorreios['package']['width']) == false) {
                return TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE;
            } else {
                $data['nVlLargura'] = $this->validateWidth($callCorreios['package']['width']);
            }

            /**
             * Validate Length correios minimun and max size before convert float to string.
             */
            if ($this->validateLength($callCorreios['package']['length']) == false) {
                return TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE;
            } else {
                $data['nVlComprimento'] = $this->validateLength($callCorreios['package']['length']);
            }

            $data['nVlPeso'] = $callCorreios['package']['weight'];
            $data['nVlDiametro'] = 0;
            $data['nVlValorDeclarado'] = $callCorreios['package']['value'];

            $data['sCdMaoPropria'] = self::MAO_PROPRIA_DEFAULT;
            $data['nCdFormato'] = self::FORMATO_DEFAULT;
            $data['sCdAvisoRecebimento'] = self::AVISO_RECEBIMENTO_DEFAULT;
            $data['StrRetorno'] = self::RRETORNO_DEFAULT;

            $data = http_build_query($data);

            curl_setopt($curl = curl_init(self::URL_WEBSERVICE_CORREIOS . '?' . $data), CURLOPT_RETURNTRANSFER, true);
            $resultCorreios = simplexml_load_string(curl_exec($curl));

            return $resultCorreios;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getCorreios($callCorreios)
    {
        $data = array();
        try {
            $getUserCorreios = $this->getUserCorreios();

            if (is_array($getUserCorreios)) {
                $data['nCdEmpresa'] = $getUserCorreios['nCdEmpresa'];
                $data['sex'] = $getUserCorreios['sDsSenha'];
                $data['sCepOrigem'] = $getUserCorreios['zipCode'];
            }

            $data['nCdServico'] = $callCorreios['code_service']; // $this->codeServiceCorreios();
            $data['sCepDestino'] = $callCorreios['zipCode'];
            /**
             * Validate Height correios minimun and max size before convert float to string.
             */
            if ($this->validateHeight($callCorreios['package']['height']) == false) {
                return TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE;
            } else {
                $data['nVlAltura'] = $this->validateHeight($callCorreios['package']['height']);
            }

            /**
             * Validate Width correios minimun and max size before convert float to string.
             */
            if ($this->validateWidth($callCorreios['package']['width']) == false) {
                return TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE;
            } else {
                $data['nVlLargura'] = $this->validateWidth($callCorreios['package']['width']);
            }

            /**
             * Validate Length correios minimun and max size before convert float to string.
             */
            if ($this->validateLength($callCorreios['package']['length']) == false) {
                return TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE;
            } else {
                $data['nVlComprimento'] = $this->validateLength($callCorreios['package']['length']);
            }

            $data['nVlPeso'] = $callCorreios['package']['weight'];
            $data['nVlDiametro'] = 0;
            $data['nVlValorDeclarado'] = $callCorreios['package']['value'];

            $data['sCdMaoPropria'] = self::MAO_PROPRIA_DEFAULT;
            $data['nCdFormato'] = self::FORMATO_DEFAULT;
            $data['sCdAvisoRecebimento'] = self::AVISO_RECEBIMENTO_DEFAULT;
            $data['StrRetorno'] = self::RRETORNO_DEFAULT;

            $data = http_build_query($data);

            curl_setopt($curl = curl_init(self::URL_WEBSERVICE_CORREIOS . '?' . $data), CURLOPT_RETURNTRANSFER, true);
            $resultCorreios = simplexml_load_string(curl_exec($curl));

            return $resultCorreios;
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Method validate height correios
     * minimun and max size before
     * convert float to string.
     */
    public function validateHeight($height)
    {
        $removeCaracterCep = array(
            '.',
            ',',
            '-',
            '+',
            '=',
            '@',
            '#',
            '$',
            '%',
            '¨',
            '&',
            '*'
        );
        if ($height == '0.00') {
            return false;
        } elseif ($height < self::MINIMUM_HEIGHT) {
            return str_replace($removeCaracterCep, "", self::MINIMUM_HEIGHT);
        } elseif ($height > self::MAX_HEIGHT) {
            return false;
        } else {
            return str_replace($removeCaracterCep, "", $height);
        }
    }

    /**
     * Method validate width correios
     * minimun and max size before
     * convert float to string.
     */
    public function validateWidth($width)
    {
        $removeCaracterCep = array(
            '.',
            ',',
            '-',
            '+',
            '=',
            '@',
            '#',
            '$',
            '%',
            '¨',
            '&',
            '*'
        );
        if ($width == '0.00') {
            return false;
        } elseif ($width < self::MINIMUN_WIDTH) {
            return str_replace($removeCaracterCep, "", self::MINIMUN_WIDTH);
        } elseif ($width > self::MAX_WIDTH) {
            return false;
        } else {
            return str_replace($removeCaracterCep, "", $width);
        }
    }

    /**
     * Method validate length correios
     * minimun and max size before
     * convert float to string.
     */
    public function validateLength($length)
    {
        $removeCaracterCep = array(
            '.',
            ',',
            '-',
            '+',
            '=',
            '@',
            '#',
            '$',
            '%',
            '¨',
            '&',
            '*'
        );
        if ($length == '0.00') {
            return false;
        } elseif ($length < self::MINIMUN_LENGTH) {
            return str_replace($removeCaracterCep, "", self::MINIMUN_LENGTH);
        } elseif ($length > self::MAX_LENGTH) {
            return false;
        } else {
            return str_replace($removeCaracterCep, "", $length);
        }
    }

    /**
     * Method return url default.
     */
    public function getUrlHost()
    {
        try {
            $db = $this->database();
            $xtStoreQuery = $db->Execute("SELECT * FROM " . DB_PREFIX . "_stores");
            if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
                return  $xtStoreQuery->fields['shop_http'];
            } else {
                return  $xtStoreQuery->fields['shop_https'];
            }

        } catch (Exception $e) {
            return $_SERVER['HTTP_REFERER'];
        }
    }


public  function formatUrl ($url){
       $removeCaracterCep = array(
            '?page=product&info',
            '?pagecart/',
            'index.php',
            '/bp',
            '/?page=index',
	    '?page=product&info',
	    '/?pageindex/',
	    '/?page=customer',
	    '/?page=index',
	    '/?pagecart',
	    '/?pagecustomer',
	    '&',
	    '?page//',
	    '?pagecustomer',
	    '?page/',
	    '&page_action=login',
'&page_action=password_reset',
        );
	return rtrim(str_replace($removeCaracterCep, "", $url), '/') . '/';
}


}
