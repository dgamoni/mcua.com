<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Description of OPTISAVE
 *
 */
class TF_OPTISAVE extends TF_TFUSE {

    public $_the_class_name = 'OPTISAVE';

    public function __construct() {
        parent::__construct();
    }

    function post_text($option, &$post_options) {
        if (!isset($_POST[$option['id']]))
            return;
        $data = htmlentities($_POST[$option['id']], ENT_QUOTES, 'UTF-8');
        $post_options[$option['id']] = $data;
    }

    function admin_text($option, $values, &$framework_options) {
        if (!isset($values[$option['id']]))
            return;
        $data = htmlentities($values[$option['id']], ENT_QUOTES, 'UTF-8');
        $framework_options[$option['id']] = $data;
    }

    function taxonomy_text($option, $term_id, &$taxonomy_options) {
        if (!isset($_POST[$option['id']]))
            return;
        $data = htmlentities($_POST[$option['id']], ENT_QUOTES, 'UTF-8');
        $taxonomy_options[$term_id][$option['id']] = $data;
    }

    function post_textarray($option, &$post_options) {
        if (!isset($_POST[$option['id']]))
            return;
        $post_options[$option['id']] = $_POST[$option['id']];
    }

    function admin_textarray($option, $values, &$framework_options) {
        $option['id'] = rtrim($option['id'], '[]'); // to be sure
        if (!isset($values[$option['id']]))
            return;
        $framework_options[$option['id']] = $values[$option['id']];
    }

    function taxonomy_textarray($option, $term_id, &$taxonomy_options) {
        if (!isset($_POST[$option['id']]))
            return;
        $taxonomy_options[$term_id][$option['id']] = $_POST[$option['id']];
    }

    /*multi_input optisave*/

    function post_multiple_input($option, &$post_options){

        $data = isset($_POST[$option['id']]) ? $_POST[$option['id']] : false;
        $post_options[$option['id']] = (array)$data;
    }

    function admin_multiple_input($option, $values, &$framework_options){

        $data = isset($values[$option['id']]) ? $values[$option['id']] : false;
        $framework_options[$option['id']] = (array)$data;
    }

    function taxonomy_multiple_input($option, $term_id, &$taxonomy_options) {

        $data = isset($_POST[$option['id']]) ? $_POST[$option['id']] : false;
        $taxonomy_options[$term_id][$option['id']] = (array)$data;
    }

    /*end multi_input optisave*/

    function post_checkbox($option, &$post_options) {
        $data = isset($_POST[$option['id']]) ? $_POST[$option['id']] : 'false';
        $post_options[$option['id']] = $data;
    }

    function admin_checkbox($option, $values, &$framework_options) {
        $data = isset($values[$option['id']]) ? $values[$option['id']] : 'false';
        $framework_options[$option['id']] = $data;
    }

    function taxonomy_checkbox($option, $term_id, &$taxonomy_options) {
        $data = isset($_POST[$option['id']]) ? $_POST[$option['id']] : 'false';
        $taxonomy_options[$term_id][$option['id']] = $data;
    }

    function post_multi($option, &$post_options) {
        $val = str_replace(' ', '', $_POST[$option['id']]);
        $post_options[$option['id']] = $val;
    }

    function admin_multi($option, $values, &$framework_options) {
        $val = str_replace(' ', '', $values[$option['id']]);
        $framework_options[$option['id']] = $val;
    }

    function taxonomy_multi($option, $term_id, &$taxonomy_options) {
        $val = str_replace(' ', '', $_POST[$option['id']]);
        $taxonomy_options[$term_id][$option['id']] = $val;
    }

    function admin_boxes($option, $values, &$framework_options) {
        $framework_options[$option['id']]['count'] = $option['count'];

        for ($k = 1; $k <= $option['count']; $k++) {
            $id_page = $option['id'] . $k . '_page';
            $id_post = $option['id'] . $k . '_post';
            $id_box = $option['id'] . $k;

            if (isset($values[$id_box]))
                $framework_options[$option['id']][$id_box] = $values[$id_box];
            if (isset($values[$id_page]) && $values[$id_page] != '')
                $framework_options[$option['id']][$id_page] = str_replace(' ', '', $values[$id_page]);
            if (isset($values[$id_post]) && $values[$id_post] != '')
                $framework_options[$option['id']][$id_post] = str_replace(' ', '', $values[$id_post]);
        }
    }

    function admin_table($option, $values, &$framework_options){
        $data = isset($values[$option['id']]) ? (array)json_decode($values[$option['id']]) : false;

        if(!empty($data)){
            $i=0;
            foreach($data as $val){
                $val=(array)$val;
                foreach($val as $k=>$v)
                    $temp[$k][$i]=$v;
                $i++;
            }
            $framework_options[$option['id']] = (array)$temp;
        }
    }
    function post_table($option, &$post_options){
        $data = isset($_POST[$option['id']]) ? (array)json_decode($_POST[$option['id']]) : false;

        if(!empty($data)){
            $i=0;
            foreach($data as $val){
                $val=(array)$val;
                foreach($val as $k=>$v)
                    $temp[$k][$i]=$v;
                $i++;
            }
            $post_options[$option['id']] = (array)$temp;
        }
    }

    public function has_method($method) {
        if (method_exists($this, $method))
            return true;
        else
            return false;
    }

}