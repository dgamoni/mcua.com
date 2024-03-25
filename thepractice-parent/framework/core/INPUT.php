<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Description of INPUT
 *
 */
class TF_INPUT extends TF_TFUSE {

    public $_the_class_name = 'INPUT';

    public function __construct() {
        parent::__construct();
    }

    public function is_ajax_request() {
        /*$ajax_actions = array('tfuse_get_suggest');
        if (isset($_REQUEST['action']) && isset($ajax_actions[$_REQUEST['action']]))
            return TRUE;*/
        return (bool) ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') || $_SERVER['REQUEST_URI'] === '/wp-admin/admin-ajax.php');
    }

}