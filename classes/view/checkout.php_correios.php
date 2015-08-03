<?php
$xt_correios = new xt_correios();
$checkout = new checkout();

$getSizeProduct = $xt_correios->getSizeProductCheckout($_SESSION['cart']->content);

$code_service = explode("_", $_POST['selected_shipping']);

$codeServiceCorreios = '';
if (!empty($code_service[1])){
    $codeServiceCorreios = $code_service[1];
}

if ($codeServiceCorreios == 'correios') {
    $removeCaracterCep = array('.', ',', '-', '+', '=', '@', '#', '$', '%', '¨', '&', '*');

    $zipCode = str_replace($removeCaracterCep, "", $_SESSION['customer']->customer_shipping_address[customers_postcode]);

    $callCorreios = array('zipCode' => $zipCode,
        'package' => array('height' => $getSizeProduct['height'],
            'length' => $getSizeProduct['length'],
            'width' => $getSizeProduct['width'],
            'weight' => $getSizeProduct['weight'],
            'value' => $getSizeProduct['price']),
        'code_service' => $code_service[0]);

    $getCorreiosRest = $xt_correios->getCorreios($callCorreios);

    if ($getCorreiosRest->cServico->Erro == 0) {

        $_SESSION['cart']->sub_content['shipping']['customers_id'] = '1';
        $_SESSION['cart']->sub_content['shipping']['products_name'] = (string) $xt_correios->getDescriptionService($getCorreiosRest->cServico->Codigo);
        $_SESSION['cart']->sub_content['shipping']['products_key'] = 'shipping';
        $_SESSION['cart']->sub_content['shipping']['products_key_id'] = (string) $getCorreiosRest->cServico->Codigo;
        $_SESSION['cart']->sub_content['shipping']['products_model'] = (string) $getCorreiosRest->cServico->Codigo;
        $_SESSION['cart']->sub_content['shipping']['products_quantity'] = '';
        $_SESSION['cart']->sub_content['shipping']['products_price'] = number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');
        //$_SESSION['cart']->sub_content['shipping']['products_price'] = (string)$getCorreiosRest->cServico->Valor;
        $_SESSION['cart']->sub_content['shipping']['products_tax_class'] = '0';
        $_SESSION['cart']->sub_content['shipping']['products_discount'] = '';
        $_SESSION['cart']->sub_content['shipping']['type'] = 'shipping';
        $_SESSION['cart']->sub_content['shipping']['status'] = '0';
        $_SESSION['cart']->sub_content['shipping']['sort_order'] = '';
        $_SESSION['cart']->sub_content['shipping']['shop_id'] = '';

        $_SESSION['cart']->sub_content_total['formated'] = "BRL " . number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');
        $_SESSION['cart']->sub_content_total['plain'] = number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');
        $_SESSION['cart']->sub_content_total['plain_otax'] = number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');

        $_SESSION['selected_shipping'] = (string) $getCorreiosRest->cServico->Codigo;

        // Shipping info.
        $_SESSION['shipping_info_correios']['shipping_id'] = (string) $getCorreiosRest->cServico->Codigo;
        $_SESSION['shipping_info_correios']['shipping_name'] = (string) $xt_correios->getDescriptionService($getCorreiosRest->cServico->Codigo);
        $_SESSION['shipping_info_correios']['shipping_desc'] = (string) $xt_correios->getDescriptionService($getCorreiosRest->cServico->Codigo);
        $_SESSION['shipping_info_correios']['shipping_dir'] = '';
        $_SESSION['shipping_info_correios']['shipping_code'] = (string) $xt_correios->getDescriptionService($getCorreiosRest->cServico->Codigo);
        $_SESSION['shipping_info_correios']['shipping_icon'] = '';
        $_SESSION['shipping_info_correios']['shipping_tax_class'] = '0';

        $_SESSION['shipping_info_correios']['shipping_price']['formated'] = "BRL " . number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');
        $_SESSION['shipping_info_correios']['shipping_price']['plain'] = number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');
        $_SESSION['shipping_info_correios']['shipping_price']['plain_otax'] = number_format(str_replace(',', '.', str_replace('.', '', (string) $getCorreiosRest->cServico->Valor)), 2, '.', ',');

        $_SESSION['shipping_info_correios']['shipping_price']['shipping_tax_class'] = '0';
        $_SESSION['shipping_info_correios']['shipping_type'] = 'shipping';
        $_SESSION['shipping_info_correios']['shipping_tpl'] = '';
        $_SESSION['shipping_info_correios']['shipping_selected'] = (string) $xt_correios->getDescriptionService($getCorreiosRest->cServico->Codigo);
    }
} else {

    foreach ($checkout->_getShipping() as $value) {

        if ($value['shipping_id'] == $code_service[0]) {

            $_SESSION['cart']->sub_content['shipping']['customers_id'] = '1';
            $_SESSION['cart']->sub_content['shipping']['products_name'] = $value['shipping_name'];
            $_SESSION['cart']->sub_content['shipping']['products_key'] = $value['shipping_type'];
            $_SESSION['cart']->sub_content['shipping']['products_key_id'] = $value['shipping_id'];
            $_SESSION['cart']->sub_content['shipping']['products_model'] = $value['shipping_id'];
            $_SESSION['cart']->sub_content['shipping']['products_quantity'] = '';
            $_SESSION['cart']->sub_content['shipping']['products_price'] = $value['shipping_price']['plain'];
            $_SESSION['cart']->sub_content['shipping']['products_tax_class'] = $value['shipping_tax_class'];
            $_SESSION['cart']->sub_content['shipping']['products_discount'] = '';
            $_SESSION['cart']->sub_content['shipping']['type'] = $value['shipping_type'];
            $_SESSION['cart']->sub_content['shipping']['status'] = '0';
            $_SESSION['cart']->sub_content['shipping']['sort_order'] = '';
            $_SESSION['cart']->sub_content['shipping']['shop_id'] = '';

            $_SESSION['cart']->sub_content_total['formated'] = $value['shipping_price']['formated'];
            $_SESSION['cart']->sub_content_total['plain'] = $value['shipping_price']['plain'];
            $_SESSION['cart']->sub_content_total['plain_otax'] = $value['shipping_price']['plain_otax'];

            $_SESSION['selected_shipping'] = $value['shipping_id'];


            // Shipping info.
            $_SESSION['shipping_info_correios']['shipping_id'] = $value['shipping_id'];
            $_SESSION['shipping_info_correios']['shipping_name'] = $value['shipping_name'];
            $_SESSION['shipping_info_correios']['shipping_desc'] = $value['shipping_name'];
            $_SESSION['shipping_info_correios']['shipping_dir'] = '';
            $_SESSION['shipping_info_correios']['shipping_code'] = $value['shipping_name'];
            $_SESSION['shipping_info_correios']['shipping_icon'] = '';
            $_SESSION['shipping_info_correios']['shipping_tax_class'] = '0';
            $_SESSION['shipping_info_correios']['shipping_price']['formated'] = $value['shipping_price']['formated'];
            $_SESSION['shipping_info_correios']['shipping_price']['plain'] = $value['shipping_price']['plain'];
            $_SESSION['shipping_info_correios']['shipping_price']['plain_otax'] = $value['shipping_price']['plain_otax'];
            $_SESSION['shipping_info_correios']['shipping_price']['shipping_tax_class'] = '0';
            $_SESSION['shipping_info_correios']['shipping_type'] = 'shipping';
            $_SESSION['shipping_info_correios']['shipping_tpl'] = '';
            $_SESSION['shipping_info_correios']['shipping_selected'] = $value['shipping_name'];
        }
    }
}