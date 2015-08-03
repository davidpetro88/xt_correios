<?php

$xt_correios = new xt_correios();
$checkout = new checkout();
$productList = json_decode($_GET['product']);

if (!empty($productList)) {

    $getSizeProduct = $xt_correios->getSizeProduct($productList);
} else {
    $productList = json_decode(stripslashes($_GET['product']));
	if (empty($productList)){
  	 //$t = json_decode(str_replace ('\"','"', $_GET['product']), true);
	}

    $getSizeProduct = $xt_correios->getSizeProduct($productList);

}

if (!empty($_GET['zipCode'])) {

    $removeCaracterCep = array('.', ',', '-', '+', '=', '@', '#', '$', '%', '¨', '&', '*');
    $zipCode = str_replace($removeCaracterCep, "", $_GET['zipCode']);
    $callCorreios = array('zipCode' => $zipCode,
        'package' => array('height' => $getSizeProduct['height'],
            'length' => $getSizeProduct['length'],
            'width' => $getSizeProduct['width'],
            'weight' => $getSizeProduct['weight'],
            'value' => $getSizeProduct['price']));
    $callShipping = $xt_correios->correiosConsultExpected($callCorreios);
    $shippingDatabase = $checkout->_getShipping();


} else {

    $shippingDatabase = false;
}
?>	

<style type="text/css"> 
    #shipping-name-plgCorreios {
        border:1px #C0C0C0 solid;
        background:#FFF;
        width: 100%;
        min-height: 10px;
        display:table;
    }
</style> 

<?php
if ((is_null($shippingDatabase)) && is_null($callShipping)) {
    header('HTTP/1.1 500 Internal Server');
    header('Content-Type: application/json');
    ?>
<?php } else { ?>

    <?php if (!empty($shippingDatabase)) { ?>
        <!-- SERVIÇOS DE ENTRGA XT-Commerce. </p>-->
        <?php foreach ($shippingDatabase as $key => $value) { ?>
            <div id="shipping-name-plgCorreios">
                <table>
                    <input type="hidden" name="plg_correios" value="1">
                    <tr>
                        <td style="width:5%;">
                            <input class="input-shipping-plgCorreios" type='radio' name='selected_shipping' value='<?php echo $value['shipping_id']; ?>'/>
                        </td>
                        <td style="width:50%;text-align:left;">
                            <?php echo $value['shipping_name']; ?>  ( <?php echo $value['shipping_price']['formated']; ?>)
                        <td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $value['shipping_desc']; ?> 
                        <td>
                    </tr>
                </table>
            </div> </br>
        <?php } ?>
    <?php } ?>

    <?php if (is_object($callShipping)) { ?>    
        <!-- SERVIÇOS DE ENTRGA CORREIOS. </p>-->
        <?php for ($i = 0; $i < count($callShipping->cServico); ++$i) { ?>
            <?php if ($callShipping->cServico[$i]->Erro == 0) { ?>
                <div id="shipping-name-plgCorreios">
                    <table>
                        <input type="hidden" name="plg_correios" value="1">
                        <tr>
                            <td style="width:5%;">
                                <input class="input-shipping-plgCorreios" type='radio' name='selected_shipping' value='<?php echo "" . $callShipping->cServico[$i]->Codigo . "_correios"; ?>' checked="1"/>
                            </td>
                            <td style="width:50%;text-align:left;">
                                <?php echo $xt_correios->getDescriptionService($callShipping->cServico[$i]->Codigo); ?>  ( BRL <?php echo $callShipping->cServico[$i]->Valor; ?>)
                            <td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <b> <?php echo TEXT_MENU_CONSULT_CORREIOS_TIME; ?> </b> (<?php echo $callShipping->cServico[$i]->PrazoEntrega; ?> Dias) | <b><?php echo TEXT_SATURDAY_DELIVERY; ?></b> (<?php echo $callShipping->cServico[$i]->EntregaSabado; ?>)
                            <td>
                        </tr>
                    </table>
                </div> </br>
            <?php } ?>
        <?php } ?>
    <?php } else { ?>
        <div id="shipping-name-plgCorreios">
            <table>
                <input type="hidden" name="plg_correios" value="1">
                <tr>
                    <td style="width:5%;">
                    </td>
                    <td style="width:50%;text-align:left;">
                        <h2 style="color: red;"><?php echo TEXT_PRODUCT_WITH_SIZE_UNAVAILABLE; ?></h2>
                    <td>
                </tr>
                <tr>
                    <td colspan="2">
                    <td>
                </tr>
            </table>
        </div> </br>
        <?php if (is_null($shippingDatabase)) { ?>
            <script type="text/javascript">

                $(document).ready(function() {
                    $("p.float-right").remove();
                });
            </script>
        <?php } ?>
    <?php } ?>
<?php } ?>


