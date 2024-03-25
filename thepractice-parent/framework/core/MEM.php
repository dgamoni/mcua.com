<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Mem data across framework
 */
class TF_MEM extends TF_TFUSE {

    public $_the_class_name = 'MEM';
    public $db = array();

    public function __construct() {
        parent::__construct();
    }

    public function __init() {
        
    }

    public function is_set() {
        if (count(func_get_args()) == 0)
            return FALSE;
        foreach (func_get_args() as $arg) {
            if (!isset($curpointer))
                $curpointer = $this->db;
            if (isset($curpointer[$arg])) {
                $curpointer = $curpointer[$arg];
            }
            else
                return FALSE;
        }
        return TRUE;
    }

}