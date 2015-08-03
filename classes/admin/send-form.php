<?php $xt_correios = new xt_correios(); ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<body>
    <div id="saveSucess">
        <div class="container-top-save-sucess">
            <input class="button-close-save-sucess" type="button" value="" onclick="fecha();"/>
        </div>
        <div class="container-body-save-sucess">
            <p><?php echo TEXT_CORREIOS_UPDATED_SUCCESS; ?></p>
        </div>
    </div>
  <?php $urlLoader = $xt_correios->getUrlHost(); ?>
    <div id="loading"><img src="<?php echo $urlLoader; ?>plugins/xt_correios/images/ajax-loader12.gif" alt="" />Loading!</div>
    <form id="send_form_response" method="post" >
        <div id="container-correio">

            <div class="header">
                <div class="logo" style="width: 500px;">  </div>
                <div class="buttonTop">
                    <input class="btn" type="button" value="<?php echo TEXT_XT_CORREIOS_SAVE; ?>" onclick="postAjaxCorreiosResponse();">
                    <input class="btn" type="reset" value="<?php echo TEXT_XT_CORREIOS_RESET; ?>" />
                </div>
            </div>

            <div class="service-configuration-user">
                <div class="service-configuration-user-1"> <label> <?php echo TEXT_SERVICE_CONFIGURATION_USER; ?> </label> </div>
                <div class="service-configuration-user-2">
                    <?php $userCorreios = $xt_correios->getUserCorreios(); ?>

                    <p>	<label class="campo"> <?php echo TEXT_CORREIOS_USER; ?>:</label><input type="text" name="user" value="<?php echo $userCorreios['nCdEmpresa']; ?>" /> </p>
                    <p> <label class="campo"> <?php echo TEXT_CORREIOS_PASSWORD; ?>:</label><input type="password" name="password" value="<?php echo $userCorreios['sDsSenha']; ?>" /> </p>
                    <p>	<label class="campo"> <?php echo TEXT_CORREIOS_ZIPE_CODE_SHOPKEEPER; ?>:</label> <input type="text" name="zip_code" onkeypress="maskZipCode(this, '99999-999')" maxlength="9" value="<?php echo preg_replace('/^(.*?)(.{5})(.{3})$/', '$2-$3', $userCorreios['zipCode']) ?>" /> <?php
                        if ($userCorreios['zipCode'] == 0) {
                            echo "<label id='zipCodeEmpty' style=\'color:red;\'> " . TEXT_CORREIOS_ZIPE_CODE_COMPLETED . " </label>";
                        }
                        ?> </p>


                </div>
            </div>

            <div class="service-configuration-shipping">
                <div class="service-configuration-shipping-1"> <label> <?php echo TEXT_SERVICE_CONFIGURATION_SHIPPING; ?> </div>
                <div class="service-configuration-shipping-2">

                    <?php for ($i = 0; $i < count($getServiceCorreios = $xt_correios->getServiceCorreios()); ++$i) { ?>
                        <p>
                            <?php echo TEXT_CORREIOS_CODE; ?>: 	<input type="text" name="code[]" value="<?php echo $getServiceCorreios[$i]['code_service']; ?>" size="4" readonly />
                            <?php echo TEXT_CORREIOS_DESCRIPTION; ?>:  <input type="text" name="description[]" value="<?php echo $getServiceCorreios[$i]['description']; ?>" size="25" readonly />
                            <?php echo TEXT_CORREIOS_ACTIVE; ?>: <select name="active[]">
                                <?php if ($getServiceCorreios[$i]['active'] == 'S') { ?>
                                    <option name="code_<?php echo $getServiceCorreios[$i]['code_service']; ?>" selected value="<?php echo $getServiceCorreios[$i]['code_service']; ?>_S">S</option>
                                    <option name="code_<?php echo $getServiceCorreios[$i]['code_service']; ?>" value="<?php echo $getServiceCorreios[$i]['code_service']; ?>_N">N</option>
                                <?php } else { ?>
                                    <option name="code_<?php echo $getServiceCorreios[$i]['code_service']; ?>" value="<?php echo $getServiceCorreios[$i]['code_service']; ?>_S">S</option>
                                    <option name="code_<?php echo $getServiceCorreios[$i]['code_service']; ?>" selected value="<?php echo $getServiceCorreios[$i]['code_service']; ?>_N">N</option>
                                <?php } ?>
                            </select>
                        </p>
                    <?php } ?>
                </div>
            </div>

            <div class="footer">
                <span> Criado em 2013 - <a href="https://github.com/davidpetro88" target="_blank">https://github.com/davidpetro88 </a> </span>
            </div>
        </div>
    </form>


</body>

<script type="text/javascript">
    function postAjaxCorreiosResponse()
    {
        $('#loading').show();
        $('#container-correio').hide();

        $.ajax({
            type: 'POST',
            url: '<?php echo $xt_correios->getUrlHost(); ?>/xtAdmin/adminHandler.php?load_section=xt_correiosResponse&plugin=xt_correios',
            data: $("#send_form_response").serialize(),
            dataType: 'html',
            success: function(data) {
                alert("SUCESS");
                $("#zipCodeEmpty").remove();
                $("#david").html(data);
                $('#loading').hide();
                $('#container-correio').show();
                $('#saveSucess').show();
            },
            error: function(data) {
            	alert("ERROR");
                $("#david").html("An error occured.");
                $('#loading').hide();
                $('#container-correio').show();
            }
        });
    }

    function maskZipCode(src, mask) {
        var i = src.value.length;
        var saida = mask.substring(0, 1);
        var texto = mask.substring(i);

        if (texto.substring(0, 1) != saida) {
            src.value += texto.substring(0, 1);
        }
    }

    function validateNumber(evt) {
        var e = evt || window.event;
        var key = e.keyCode || e.which;

        if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                // numbers
                key >= 48 && key <= 57 ||
                // Numeric keypad
                key >= 96 && key <= 105 ||
                // Backspace and Tab and Enter
                key == 8 || key == 9 || key == 13 ||
                // Home and End
                key == 35 || key == 36 ||
                // left and right arrows
                key == 37 || key == 39 ||
                // Del and Ins
                key == 46 || key == 45) {
            // input is VALID
        }
        else {
            // input is INVALID
            e.returnValue = false;
            if (e.preventDefault)
                e.preventDefault();
        }
    }

    function fecha() {
        document.getElementById('saveSucess').style.display = "none";
    }
</script>
