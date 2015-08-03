<?php

$xt_correios = new xt_correios();
$productList = json_decode($_GET['product']);
if (empty($productList)) {
    $productList = json_decode(stripslashes($_GET['product']));
}
$getSizeProduct = $xt_correios->getSizeProduct($productList);

if (!empty($_GET['zipCode'])) {
    $removeCaracterCep = array('.', ',', '-', '+', '=', '@', '#', '$', '%', '¨', '&', '*');
    $zipCode = str_replace($removeCaracterCep, "", $_GET['zipCode']);
    $callCorreios = array('zipCode' => $zipCode,
        'package' => array('height' => $getSizeProduct['height'],
            'length' => $getSizeProduct['length'],
            'width' => $getSizeProduct['width'],
            'weight' => $getSizeProduct['weight'],
            'value' => $getSizeProduct['price']));

    $consultExpected = $xt_correios->correiosConsultExpected($callCorreios);
} else {
    $consultExpected = false;
}

?>
<style type="text/css">
    #boxes #dialog #result-consult-correios{
        width: 400px;
        min-height: 50px;
        display:table;
        margin-left:auto;
        margin-right:auto;
        font-family:Times New Roman;
    }
    #result-consult-correios #table-consult-correios {
        width: 400px;
        min-height: 50px;
        display:table;
    }
    #table-consult-correios {
        display:table;
        border-collapse: collapse;
        font: normal 11px verdana, arial, helvetica, sans-serif;
        color: #363636;
        background: #FFF;
        text-align:left;
    }
    #table-consult-correios caption {
        text-align: center;
        font: bold 16px arial, helvetica, sans-serif;
        background: transparent;
        padding:6px 4px 8px 0px;
        color: #CC00FF;
        text-transform: uppercase;
    }
    #table-consult-correios thead, tfoot {
        background:url(bg1.png) repeat-x;
        text-align:left;
        height:30px;
    }
    #table-consult-correios thead th, tfoot th {
        padding:5px;
    }
    #table-consult-correios table a {
        color: #333333;
        text-decoration:none;
    }
    #table-consult-correios table a:hover {
        text-decoration:underline;
    }
    #table-consult-correios tr.odd {
        background: #f1f1f1;
    }
    #table-consult-correios tbody th, tbody td {
        padding:5px;
    }
    #Loader {
        display:none;
    }
</style>
<div id='result-consult-correios'>
    <table id='table-consult-correios' border='1'>
        <?php if (!empty($consultExpected)) { ?>
            <?php if ($consultExpected == TEXT_SERVICE_UNAVAILABLE) { ?>
                <tr>
                    <td colspan="3"> <?php echo TEXT_SERVICE_UNAVAILABLE; ?> </td>
                </tr>
            <?php } elseif ($consultExpected == TEXT_PRODUCT_WITH_SHIPPING_UNAVAILABLE) { ?>
                <tr>
                    <td colspan="3"> <?php echo TEXT_PRODUCT_WITH_SHIPPING_UNAVAILABLE; ?> </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="3" style="text-align:center;"> <h2> <?php echo TEXT_TITLE_SERVICE_SHIPPING_STORE; ?>. </h2> </td>
                </tr>
                <?php for ($i = 0; $i < count($consultExpected->cServico); ++$i) { ?>
                    <?php if ($consultExpected->cServico[$i]->Erro == 0) { ?>
                        <tr>
                            <td> <input type="text" name="description" value="<?php echo $xt_correios->getDescriptionService($consultExpected->cServico[$i]->Codigo); ?> " size="20" readonly /> </td>
                            <td> <input type="text" name="expected_time" value="<?php echo $consultExpected->cServico[$i]->PrazoEntrega; ?> / Dia(s)" size="8" readonly /> </td>
                            <td> <input type="text" name="value" value="<?php echo $consultExpected->cServico[$i]->Valor; ?>" size="4" readonly /> </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

        <?php } else { ?>
            <tr>
                <td colspan="3"> <?php echo TEXT_EMPTY_ZIP_CODE; ?> </td>
            </tr>
        <?php } ?>
    </table>
</div>
