<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

class xt_correiosConsultExpected {

    public function database() {
        global $language, $db;

        return $db;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function _getParams() {
        $params = array();
        include ("view/expected-delivery.php");
        exit();
        return $params;
    }

    function _get($ID = 0) {
        $obj = new stdClass();
        return $obj;
    }

    function _set($data, $set_type = 'edit') {
        $obj = new stdClass();
        return $obj;
    }

    function _unset($id = 0) {
        
    }
}
?>