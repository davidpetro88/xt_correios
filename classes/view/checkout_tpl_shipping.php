<?php
$xt_correios = new xt_correios();
$removeCaracterCep = array('.', ',', '-', '+', '=', '@', '#', '$', '%', '¨', '&', '*');

global $page;

if ($page->page_action == 'shipping') {
    Global $cartList;

    foreach ($_SESSION['cart']->content as $productArray) {
        $product[] = array('product_id' => (int) $productArray['products_id'],
            'products_quantity' => $productArray['products_quantity']);
    }
    $cartList = json_encode($product);

}
?>

<script type="text/javascript">

    $(document).ready(function() {

        var zip_code_customer = <?php
if (!empty($_SESSION['customer']->customer_shipping_address['customers_postcode'])) {
    echo str_replace($removeCaracterCep, "", $_SESSION['customer']->customer_shipping_address['customers_postcode']);
} else {
    echo 0;
}
?>;
        $('div.box.box-white.box-hover').hide();
        $("div#checkout-shipping form .box-white").hide();
        $("div#checkout-shipping .box-grey form").append("<div id='loading'><img src='<?php echo $xt_correios->getUrlHost(); ?>/plugins/xt_correios/images/ajax-loader12.gif' alt='' />Loading!</div>");

        if (zip_code_customer == 0) {
            alert(zip_code_customer);
        } else {

            $("p").remove(".shipping-name");
            $('div.box.box-white.box-hover').hide();
            $("div#checkout-shipping .box-grey form").append("<div id='plg_get_it'></div>");


            $.ajax({
                type: 'GET',
                url: '<?php echo $xt_correios->getUrlHost(); ?>/cronjob.php?checkout=1&zipCode=' + zip_code_customer + '&product=<?php echo $cartList; ?>',
                dataType: 'html',
                success: function(data) {

                    $("div#checkout-shipping .box-grey form #loading").hide();
                    $("#plg_get_it").html(data);

                },
                error: function(data) {
                    $("div#checkout-shipping .box-grey form #loading").hide();
                    var correioResultEmpty = "<?php echo TEXT_RESULT_CORREIO_AVAILABLE; ?>;"

                    $("div#checkout-shipping .box-grey form").append(correioResultEmpty);
                    $("p.float-right").remove();
                }
            });
        }

    });
</script>
