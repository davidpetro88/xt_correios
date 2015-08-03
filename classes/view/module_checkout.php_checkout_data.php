<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

$data = array('data' => $_SESSION['cart']->show_content,
    'payment_info' => $payment_info,
    'shipping_info' => $_SESSION['shipping_info_correios'],
    'post_form' => $post_form,
    'sub_total' => $_SESSION['cart']->content_total['formated'],
    'sub_data' => $_SESSION['cart']->show_sub_content,
    'tax' => $_SESSION['cart']->tax,
    'total' => $_SESSION['cart']->total['formated']
);

