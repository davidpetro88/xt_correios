<?php
$xt_correios = new xt_correios();
$urlComplete = $xt_correios->getUrlHost().'/';
?>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript"
	src="<?php echo $urlComplete; ?>plugins/xt_correios/js/form_expected.js"></script>
<!-- include js -->
<link rel="stylesheet" type="text/css"
	href="<?php echo $urlComplete; ?>plugins/xt_correios/css/form_expected.css">
<!-- include css -->
<?php
Global $cartList;

if ($_GET['page'] == 'cart') {

    foreach ($_SESSION['cart']->content as $productArray) {

        $product[] = array(
            'product_id' => (int) $productArray['products_id'],
            'products_quantity' => $productArray['products_quantity']
        );
    }

    $cartList = json_encode($product);
} elseif ($_GET['page'] == 'product') {

    $product[] = array(
        'product_id' => $_GET['info'],
        'products_quantity' => 1
    );

    $cartList = json_encode($product);
}
?>

<div id="consult-correios">
	<div class="form-zip-code">
		<form id="form-consult">
			<div style="width: 100%; height: auto; display: table;">
				<div style="width: 35%; height: auto;">
					<div
						style="width: 15%; min-height: 21px; float: left; margin-left: 5%; padding-top: 6px;">
						<img
							src="<?php echo $urlComplete; ?>plugins/xt_correios/images/shipping.png"
							alt="" />
					</div>
					<div
						style="margin-left: 5px; width: 25%; min-height: 21px; float: left; font-weight: bold; padding-top: 8px;">
						Frete</div>
				</div>
				<div style="width: 60%; height: auto; float: left;">
					<input
						style="float: left; width: 100px; height: 25px; font-weight: bold; text-align: center; -webkit-border-radius: 4x; -moz-border-radius: 4px; border-radius: 4px;"
						name="cep" id="fieldCep" value=""
						onkeypress="maskZipCode(this, '99999-999')" maxlength="9"
						onkeydown="if (event.keycode)
                                        ajaxPostConsult();"> <input
						style="float: left; font-weight: bold; text-align: center; margin-left: 3%; height: 30px; -webkit-border-radius: 4x; -moz-border-radius: 4px; border-radius: 4px;"
						class="btn" type="button" value="Ok" onclick="ajaxPostConsult();">
					<div id="loading">
						<img
							src="<?php echo $urlComplete; ?>plugins/xt_correios/images/ajax-loader12.gif"
							alt="" />Loading...
					</div>
				</div>
			</div>

		</form>
	</div>
	<div id="loading">
		<img
			src="<?php echo $urlComplete; ?>plugins/xt_correios/images/ajax-loader12.gif"
			alt="" />Loading...
	</div>
</div>

<div id="boxes">
	<div id="dialog" class="window">
		<a href="#" class="close"> Fechar [X]</a><br />
		<div class="result-zip-code"></div>
	</div>
	<!-- Máscara para cobrir a tela -->
	<div id="mask"></div>
</div>

<script type="text/javascript">
    function ajaxPostConsult()
    {
        var zipCode = document.getElementById('fieldCep').value;

        $('.result-zip-code').show();

        $.ajax({
            type: 'POST',
            url: '<?php echo $urlComplete; ?>cronjob.php?consult=1&zipCode=' + zipCode + '&product=<?php echo $cartList; ?>',
            data: $("#form-consult").serialize(),
            dataType: 'html',
            beforeSend: function() {
                $("#loading").show();
            },
            success: function(data) {
                modalShipping();
                $(".result-zip-code").html(data);
                $("#loading").hide();
            },
            error: function(data) {
                $(".result-zip-code").html("An error occured.");
            }
        });
    }


    $('#fieldCep').keypress(function(e) {
        if (e.keyCode == '13') {
            ajaxPostConsult();
            return false;
        }
    });

</script>