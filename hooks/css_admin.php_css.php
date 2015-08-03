<?php

function getUrlHostCss()
{
    try {
        $xt_correios = new xt_correios();
        return $xt_correios->getUrlHost().'/';
    } catch (Exception $e) {
        return $_SERVER['HTTP_REFERER'];
    }
}

echo '* {margin:0;padding:0;}';
echo '.clr {clear:both;}';
echo 'img {border:none;}';
echo 'ul {list-style:none;}';
echo 'a {color:#000;text-decoration:none;}';
echo 'a:hover {text-decoration:underline;}';
echo 'body {font-family: Arial, Helvetica, sans-serif;font-size:12px;color:#000;}';
echo '#container {position:relative;margin:0 auto;border:1px solid #777;}';
echo '#container .header {background:url(http://' .getUrlHostCss() . '/plugins/xt_correios/images/header-bg.gif) repeat-x left top;height:25px;color:#eee;line-height:22px;font-weight:bold;padding-left:10px;}';
echo '#container .contactForm {padding:10px;}';
echo '.contactForm ul  {margin-top:10px;}';
echo '.contactForm ul li  {float:left;margin-bottom:10px;width:100%;}';
echo '.contactForm ul li label {float:left;width:200px;margin-top:2px;}';
echo '.contactForm ul li select {float:left;width:150px;padding:4px;border:1px solid #a5a5a5;font-family:inherit;font-size:12px;}';
echo '.contactForm ul li input[type=text],.contactForm ul li input[type=password] {float:left;width:250px;padding:5px;border:1px solid #a5a5a5;font-family:inherit;font-size:12px;}';
echo '.contactForm ul li input[type=checkbox] {width:15px;}';
echo '.contactForm ul li input[type=button],.countryTree ul li input[type=button] {width:auto; padding:5px;font:11px tahoma,verdana,helvetica;cursor:pointer;}';

echo '#container  table th {text-align:left;background:#8a8b8d;padding:10px;}';
echo '#container  table td {text-align:left;padding:10px;border-bottom:1px solid #ccc;}';
echo '.tree,.countryTree {margin-top:10px;margin-left:20px;}';
echo '.tree h3,.countryTree h3 {font-size:13px;font-weight:bold;margin-bottom:10px;}';
echo '.tree b,.countryTree b {font-size:13px;font-weight:bold;margin-bottom:10px;}';
echo '.tree ul,.countryTree ul {margin-bottom:10px;float:left;}';
echo '.tree ul li{float:left;height:35px;padding:0px 0 0 60px;width:100%;}';
echo '.tree ul li p{padding-top:26px;float:left;}';
echo '.tree ul li input{margin-top:26px;float:left;margin-right:5px;}';
echo '.countryTree ul li {float:left;padding:0px 0 10px 60px;width:100%;}';
echo '.countryTree ul li p  {float:left;}';
echo '.countryTree ul li .flag {float:left;margin-right:5px;}';
echo '.countryTree ul li input {float:left;margin-right:5px;}';
echo '.countryTree ul li input[type=button] {cursor:pointer;font:11px tahoma,verdana,helvetica;padding: 5px;}';
echo '.warning {color:#FF0000;margin-left:250px;padding-bottom:10px;font-weight:bold;font:12px arial,tahoma,helvetica,sans-serif;}';
echo '.warnings {color:#FF0000;margin-left:256px;padding-bottom:10px;font-weight:bold;font:12px arial,tahoma,helvetica,sans-serif;}';
echo '.success {color:#008000;margin-left:256px;padding-bottom:10px;font-weight:bold;font:12px arial,tahoma,helvetica,sans-serif;}';
echo '#container1 {position:relative;margin:0 auto;border:1px solid #777;}';
echo '#container1 .header {background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/header-bg.gif) repeat-x left top;height:25px;color:#eee;line-height:22px;font-weight:bold;padding-left:10px;}';
echo '#container1 input[type=button] {cursor:pointer;font:11px tahoma,verdana,helvetica;padding: 5px;padding: 5px;}';
echo '#container2 .header {background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/header-bg.gif) repeat-x left top;height:25px;color:#eee;line-height:22px;font-weight:bold;padding-left:10px;}';

echo '#container2 {position:relative;margin:0 auto;border:1px solid #777;}';
echo '#containe2  table th {text-align:left;background:#8a8b8d;padding:10px;}';
echo '#container2  table td {text-align:left;padding:10px;border-bottom:1px solid #ccc;}';
echo '#support_message {position: absolute !important; right: 25px; top: 5px; margin-left:0px !important; font:11px arial,tahoma,helvetica,sans-serif;}';

/* * ********************************* CSS FORMULARIO *************************************** */

echo '* { font-family:Arial; }';
echo 'h2 { padding:0 0 5px 5px; }';
echo 'h2 a { color: #224f99; }';
echo 'a { color:#999; text-decoration: none; }';
echo 'a:hover { color:#802727; }';
echo 'p { padding:0 0 5px 0; }';

echo 'input {
		padding:5px;
		border:1px solid #999;
		border-radius:4px;
		-moz-border-radius:4px;
		-web-kit-border-radius:4px;
		-khtml-border-radius:4px;
}';

echo 'select {
		padding:5px;
		border:1px solid #999;
		border-radius:4px;
		-moz-border-radius:4px;
		-web-kit-border-radius:4px;
		-khtml-border-radius:4px;
}';

echo '#loading {
		display:none;
		position:absolute;
}';

echo 'body #container-correio {
      width: 85%;
      margin: 10px;
      margin-left: auto;
      margin-right: auto;
      padding: 10px;
      font-family: Geneva, Arial, Helvetica, sans-serif;
      font-size: .9em;
	  display:table;
	  border:1px solid #000;
}';

echo '#container-correio .header {
	width:100%;
	min-height:15%;
	float:left;
	display:table;
	margin-top:10px;
	border-bottom:1px solid #000;
}';

if (! $urlCss != '///') {
    echo '#container-correio .header .logo {
		background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/view/correios-logo.png) no-repeat;
		width:536px;
		min-height:70px;
		float:left;
		margin-bottom:10px;
		border-right:1px solid #000;
	}';
} else {
    echo '#container-correio .header .logo {
		background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/view/correios-logo.png) no-repeat;
		width:60%px;
		min-height:70px;
		float:left;
		margin-bottom:10px;
		border-right:1px solid #000;
	}';
}

echo '#container-correio .header .buttonTop {
	  width:20%;
	  min-height:30px;
	  float:left;
	  margin-left:22%;
	  text-align:right;
}';

echo '.btn{
	border:1px #999 solid;
	background:#F0F0F0;
	padding:6px 6px 6px 6px;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
}';

echo '.btn:hover{
	border:1px #999 solid;
	background:#DDDDDD;
	padding:6px 6px 6px 6px;
	border-radius:5px;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	cursor:hand;
	cursor:pointer;
}';

echo '#container-correio .service-configuration-user{
	width:100%;
	min-height:15%;
	float:left;
	border-bottom:1px solid #000;
	margin-top:10px;
}';

echo '#container-correio .service-configuration-user .service-configuration-user-1{
	width:30%;
	min-height:50px;
	float:left;
	display:table;
}';

echo '#container-correio .service-configuration-user .service-configuration-user-1 label{
	width:100%;
	min-height:20px;
	margin-top: 30px;
	text-align: center;
	font-weight:bold;
	float:left;
	font-family: sans-serif;
	font-size: 14px;
	display:block;
}';

echo '#container-correio .service-configuration-user .service-configuration-user-2{
	width:70%;
	min-height:50px;
	float:left;
	display:table;
}';

echo '#container-correio .service-configuration-user .service-configuration-user-2 label{
	width:20%;
	padding-top:5px;
	min-height:20px;
	float:left;
}';

echo '#container-correio .package-configuration {
	width:100%;
	min-height:15%;
	float:left;
	display:table;
	border-bottom:1px solid #000;
	margin-top:10px;
}';

echo '#container-correio .package-configuration .package-configuration-1{
	width:30%;
	min-height:100px;
	float:left;
	display:table;
}';

echo '#container-correio .package-configuration .package-configuration-1 label{
	width:100%;
	min-height:20px;
	margin-top: 30px;
	text-align: center;
	font-weight:bold;
	float:left;
	font-family: sans-serif;
	font-size: 14px;
	display:block;
}';

echo '#container-correio .package-configuration .package-configuration-2{
	width:70%;
	min-height:100px;
	float:left;
	display:table;
}';

echo '#container-correio .package-configuration .package-configuration-2 #package_rows{
	width:90%;
	min-height:100px;
	float:left;
	display:table;
}';

echo '#container-correio .package-configuration .package-configuration-2 #package_rows .package-fields{
	width:50%;
	min-height:100px;
	float:left;
	display:table;
	border:1px red solid;
}';

echo '#container-correio .service-configuration-shipping{
	width:100%;
	min-height:15%;
	float:left;

	display:table;
}';

echo '#container-correio .service-configuration-shipping .service-configuration-shipping-1{
	width:30%;
	min-height:100px;
	float:left;
	display:table;
}';

echo '#container-correio .service-configuration-shipping .service-configuration-shipping-1 label{
	width:100%;
	min-height:20px;
	margin-top: 40%;
	text-align: center;
	font-weight:bold;
	float:left;
	font-family: sans-serif;
	font-size: 14px;
	display:block;
}';

echo '#container-correio .service-configuration-shipping .service-configuration-shipping-2{
	width:70%;
	min-height:100px;
	float:left;
}';

echo '#container-correio .service-configuration-special {
	width:100%;
	min-height:15%;
	float:left;

}';

echo '#saveSucess{
	width:150px;
	height:100px;
	position:absolute;
	top:20%;
	z-index:200;
	border:1px solid #000;
	background-attachment:fixed;
	display:none;
	text-align:center;
	float:left;
	margin-left:40%;
	background:#FFF;"
}';

if (! $urlCss != '///') {
    echo '#saveSucess .container-top-save-sucess{
		width:100%;
		height:22%;
		background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/background-sucess-save2.png) repeat;
		border-bottom:1px solid #000;
	}';
} else {
    echo '#saveSucess .container-top-save-sucess{
		width:100%;
		height:22%;
		background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/background-sucess-save2.png) repeat;
		border-bottom:1px solid #000;
	}';
}

if (! $urlCss != '///') {
    echo '#saveSucess .button-close-save-sucess {
		width:45px;
		height:16px;
		float:right;
		background: url(' . getUrlHost() . 'plugins/xt_correios/images/btn-close.png) no-repeat;
		margin-right:2px;
		margin-top:2%;
	}';
    echo '#saveSucess .button-close-save-sucess:hover{
		border:1px #999 solid;
		background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/btn-close-hover.png) no-repeat;
		cursor:hand;
		cursor:pointer;
	}';
} else {
    echo '#saveSucess .button-close-save-sucess {
			width:45px;
			height:16px;
			float:right;
			margin-right:2px;
			background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/btn-close.png) no-repeat;
			margin-top:2%;
	}';
    echo '.btn:hover{
			background:url(' . getUrlHostCss() . 'plugins/xt_correios/images/btn-close-hover.png) no-repeat;
			cursor:hand;
			cursor:pointer;
	}';
}

echo '#saveSucess .container-body-save-sucess {
		margin-top:15px;
		width:100%;
		height:60%;
		display:table;
}';

/*
 * echo '#container-correio .footer {
 * height: 350px;
 * text-align: center;
 * width: 90%;
 * }';
 */
echo '#container-correio .footer {
	width:100%;
	padding-top:50px;
	min-height:100px;
	display:table;
	margin-top:10px;
	border-top:1px solid #000;
	text-align: center;
	font-weight:bold;
	float:left;
	font-family: sans-serif;
	font-size: 14px;
	display:block;
}';

/*
 * echo '#saveSucess .saveSucessTop{
 * width:100%;
 * height:10px;
 * border-bottom:2px solid #000;
 * float:left;
 * z-index:200;
 * margin-top:-10%;
 * }';
 *
 * echo '#saveSucess .saveSucessTop .button-close{
 * width:20px;
 * height:20px;
 * border-bottom:2px solid #FF0000;
 * z-index:200;
 * }';
 *
 */
?>
