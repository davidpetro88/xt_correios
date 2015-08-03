<?php
$xt_correios = new xt_correios();
global $page;
if ($page->page_action == 'shipping') {
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('div.box.box-white.box-hover').hide();
            $("div#checkout-shipping form .box-white").hide();
        });
    </script>
<?php } ?>
