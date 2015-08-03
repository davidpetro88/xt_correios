<?php

/**
 *	Create table user correios, the cep is mandatory, the nCdEmpresa and sDsSenha is optional you need sign contract with correios to have.
 */
$db->Execute("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."_user_correios` (
			  `id_user_correios` INTEGER NOT NULL,
			  `nCdEmpresa` VARCHAR(200),
			  `sDsSenha` VARCHAR(200),
			  `cep_origem` NUMERIC(8) NOT NULL 
            )");

$db->Execute("INSERT INTO `".DB_PREFIX."_user_correios`(`id_user_correios`,`nCdEmpresa`, `sDsSenha`, `cep_origem`) VALUES ('1', '','', '0')");
			
/**
 *	Create table services correios and add values
 */
$db->Execute("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."_services_correios` (
			  `code_service` INTEGER   NOT NULL ,
			  `description` VARCHAR(200)   NOT NULL ,
			  `active` VARCHAR(200)   NOT NULL ,
			  PRIMARY KEY(code_service)
            )");

$db->Execute("INSERT INTO `".DB_PREFIX."_services_correios`(`code_service`, `description`, `active`) VALUES ('40010', 'SEDEX varejo', 'S')");
$db->Execute("INSERT INTO `".DB_PREFIX."_services_correios`(`code_service`, `description`, `active`) VALUES ('40045', 'SEDEX a Cobrar Varejo', 'S')");
$db->Execute("INSERT INTO `".DB_PREFIX."_services_correios`(`code_service`, `description`, `active`) VALUES ('40215', 'SEDEX 10 varejo', 'S')");
$db->Execute("INSERT INTO `".DB_PREFIX."_services_correios`(`code_service`, `description`, `active`) VALUES ('40290', 'SEDEX Hoje varejo', 'S')");
$db->Execute("INSERT INTO `".DB_PREFIX."_services_correios`(`code_service`, `description`, `active`) VALUES ('41106', 'PAC Varejo', 'S')");

/**
 *	Add Plugin in menu area.
 */
 $db->Execute("INSERT INTO ".TABLE_ADMIN_NAVIGATION." (`pid` ,`text` ,`icon` ,`url_i` ,`url_d` ,`sortorder` ,`parent` ,`type` ,`navtype`) VALUES (NULL , 'xt_correios', '../plugins/xt_correios/images/correios.png', '&plugin=xt_correios', 'adminHandler.php', '4000', 'contentroot', 'G', 'W');");
 

/**
 *	Add New fields in xt-commerce.
 */ 
if (!$this->_FieldExists('height',DB_PREFIX.'_products'))
$db->Execute("ALTER TABLE `".DB_PREFIX."_products` ADD `height` FLOAT(5, 2) NOT NULL;");

if (!$this->_FieldExists('length',DB_PREFIX.'_products'))
$db->Execute("ALTER TABLE `".DB_PREFIX."_products` ADD `length` FLOAT(5, 2) NOT NULL;");

if (!$this->_FieldExists('width',DB_PREFIX.'_products'))
$db->Execute("ALTER TABLE `".DB_PREFIX."_products` ADD `width` FLOAT(5, 2) NOT NULL;"); 

?>