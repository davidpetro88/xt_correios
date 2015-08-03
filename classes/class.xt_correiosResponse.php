<?php

defined('_VALID_CALL') or die('Direct Access is not allowed.');

class xt_correiosResponse {

    public function database() {
        global $language, $db;

        return $db;
    }

    function setPosition($position) {
        $this->position = $position;
    }

    function _getParams() {
        $params = array();
        include ("admin/response-form.php");
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

    function getValuesForm($correiosPost) {

        try {

            if ($this->activeServiceCorreios($correiosPost['service']) == true) {

                $this->saveUser($correiosPost['user']);
            }

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    function saveCepUser($cep) {
        try {
            if (!empty($cep)) {
                $db = $this->database();
                $db->Execute("UPDATE " . DB_PREFIX . "_user_correios SET cep_origem = '" . $cep . "' WHERE id_user_correios = 1");
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function saveUser($user) {
        try {
            $db = $this->database();
            if (!empty($user['user']) && !empty($user['pssw'])) {
                $db->Execute("UPDATE " . DB_PREFIX . "_user_correios SET nCdEmpresa = '" . $user['user'] . "', sDsSenha = '" . $user['pssw'] . "', cep_origem = '" . $user['zip_code'] . "' WHERE id_user_correios = 1");
                return true;
            } elseif (!empty($user['zip_code'])) {
                $db->Execute("UPDATE " . DB_PREFIX . "_user_correios SET cep_origem = '" . $user['zip_code'] . "' WHERE id_user_correios = 1");
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    function activeServiceCorreios($service) {
        try {
            $db = $this->database();
            foreach ($service as $key => $value) {
                $db->Execute("UPDATE " . DB_PREFIX . "_services_correios SET active = '" . $value[1] . "' WHERE code_service ='" . $value[0] . "'");
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>