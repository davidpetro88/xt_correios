<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

$db->Execute("DELETE FROM `" . DB_PREFIX . "_plugin_code` WHERE plugin_code = 'xt_correios'");

$db->Execute("DELETE FROM " . TABLE_ADMIN_NAVIGATION . " WHERE text = 'xt_correios'");
$db->Execute("DROP TABLE `" . DB_PREFIX . "_user_correios`");
$db->Execute("DROP TABLE `" . DB_PREFIX . "_services_correios`");


//  // Remove news fields in product.
//  if ($this->_FieldExists('height',TABLE_PRODUCTS))
//	$db->Execute("ALTER TABLE `".DB_PREFIX."_products` DROP `height`;");
//  
//  if ($this->_FieldExists('length',TABLE_PRODUCTS))
//	$db->Execute("ALTER TABLE `".DB_PREFIX."_products` DROP `length`;");
//  
//  if ($this->_FieldExists('width',TABLE_PRODUCTS))
//	$db->Execute("ALTER TABLE `".DB_PREFIX."_products` DROP `width`;");
//
?>