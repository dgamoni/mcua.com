<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AJAX
 *
 */
class TF_AJAX extends TF_TFUSE {

    public $_the_class_name     = 'AJAX';
    protected $_ajax_actions    = array();
    public $out_json            = array();
    protected $curren_ajax_cache= NULL;

    public function __construct() {
        parent::__construct();
    }

    public function __init() {
        add_action('init',          array(&$this, 'init_action'), 99 );
        add_action('tf_shutdown',   array(&$this, 'shutdown_action'), 99);
    }

    public function init_action(){
        if ($this->input->is_ajax_request())
            $this->buffer->_no_signature = TRUE;
        $this->ajax_do();
        $this->include->js_enq('ajaxurl', admin_url('admin-ajax.php'));
    }

    public function ajax_do() {
        if (!$this->input->is_ajax_request())
            return;
        if (isset($_POST['action'])) {
            if (stripos($_POST['action'], 'tfuse_ajax') !== FALSE) {
                if (isset($_POST['tf_action'])) {
                    if (substr($_POST['tf_action'], 0, 1) == '_')
                        return 'Cannot access this action.';
                    $tf_ajax_action = strtolower($_POST['tf_action']);
                }
                else
                    return;
                if (method_exists($this, $tf_ajax_action)) {
                    $this->{$tf_ajax_action}();
                } else {
                    if (array_key_exists($_POST['action'], $this->_ajax_actions)) {
                        if (method_exists($this->_ajax_actions[$_POST['action']], $tf_ajax_action))
                            $this->_ajax_actions[$_POST['action']]->{$tf_ajax_action}();
                        else
                            die('There is no such ajax action: ' . $tf_ajax_action);
                    }
                }
            }
            else if (isset($_POST['tf_action'])) {
                if (substr($_POST['action'], 0, 9) == 'tf_action') {
                    if (function_exists($_POST['tf_action']))
                        $_POST['tf_action']();
                    else
                        die('This is not a valid ajax action: ' . $_POST['tf_action']);
                } else {
                    die('This is not a valid ajax action: ' . $_POST['tf_action']);
                }
            }
        }
    }

    public function ajax_finish() {
        if (count($this->out_json) > 0)
            echo json_encode($this->out_json);
        die();
    }

    function _verify_nonce($nonce) {
        if (!check_ajax_referer($nonce, '_ajax_nonce', FALSE))
            die(json_encode(array('status' => -1, 'message' => 'Troll detected.')));
    }

    function _add_action($action_name, &$instance) {
        $this->_ajax_actions[$action_name] = $instance;

        $this->curren_ajax_cache = NULL;
    }

    public function __destruct() {
        die();
    }

    /**
     * Daca s-a adaugat ceva in out_json, inseamna ca s-a executat vre-un ajax
     * care are nevoie de output json dar nu a facut die() ca sa permita altor functii sa functioneze dupa el
     */
    public function shutdown_action()
    {
        $current_ajax = $this->get_current_ajax();
        if ($current_ajax['type'] !== NULL)
            if (count($this->out_json) > 0)
                $this->ajax_finish();
    }

    public function get_current_ajax ()
    {
        if ($this->curren_ajax_cache !== NULL)
            return $this->curren_ajax_cache;

        // Detect if it is tf_action or tfuse_ajax
        // // Detection copied from $this->do_action()
        $current_ajax = array(
            'action'    => ( isset($_POST['action']) ? $_POST['action'] : NULL ),
            'type'      => NULL, // tf_action/tfuse_ajax
            'callback'  => NULL, // function-name/[class,method]
        );

        do {
            if (!isset($_POST['action'])) break;

            if (stripos($_POST['action'], 'tfuse_ajax') !== FALSE) {
                if (isset($_POST['tf_action'])) {
                    if (substr($_POST['tf_action'], 0, 1) == '_')
                        break;
                    $tf_ajax_action = strtolower($_POST['tf_action']);
                }
                else
                    break;

                if (method_exists($this, $tf_ajax_action)) {
                    $current_ajax['type']       = 'tfuse_ajax';
                    $current_ajax['callback']   = array($this, $tf_ajax_action);
                } else {
                    if (array_key_exists($_POST['action'], $this->_ajax_actions)) {
                        if (method_exists($this->_ajax_actions[$_POST['action']], $tf_ajax_action)) {
                            $current_ajax['type']       = 'tfuse_ajax';
                            $current_ajax['callback']   = array($this->_ajax_actions[$_POST['action']], $tf_ajax_action);
                        }
                    }
                }
            }
            else if (isset($_POST['tf_action'])) {
                if (substr($_POST['action'], 0, 9) == 'tf_action') {
                    if (function_exists($_POST['tf_action'])){
                        $current_ajax['type']       = 'tf_action';
                        $current_ajax['callback']   = $_POST['tf_action'];
                    }
                }
            }
        } while (false);

        $this->curren_ajax_cache = $current_ajax;
        
        return $current_ajax;
    }

    /**
     * By 'default' all options of an form generated by optigen are saved in one place together even there are options appended from some filter
     * With this function, you can catch specific array of 'child options' to be detected and saved into another custom 'location'
     * This is useful when appending/injecting this options via filters into some optigen form and cannot change manually the code from
     * * the main form that saves that options, and do not know exactly where it is.
     * This function checks every ajax submit and if options are within the submitted options,
     * * it triggers save procedure (if the optional restrictions are passed)
     */
    public function catch_child_options_submit($arguments) {
        // $arguments Structure
        array(
            'options'           => array(), // required / options for tf_only_options()

            'skip_tf_action'    => array('or string'), // optional / skip (do not trigger save) on this "tf_action_..."s
            'only_tf_action'    => array('or string'), // optional / trigger save procedure only on this "tf_action_..."s
                // example: array('tf_action_custom_function_for_ajax_save', 'tf_action_another_function')

            'skip_tfuse_ajax'   => array('or string'), // optional / skip (do not trigger save) on this "($this->_ajax_actions[tfuse_ajax_...] or ClassName)->some_method"s
            'only_tfuse_ajax'   => array('or string'), // optional / trigger save procedure only on this "($this->_ajax_actions[tfuse_ajax_...] or ClassName)->some_method"s
                // example: array('tfuse_ajax_custom_registered_class', array('tfuse_ajax_custom_class', 'method_name') )
                // here are two types of options you can give in array:
                // // (string)'registered_class_key' from $this->_ajax_actions, that applies to all its methods
                // // (array)['registered_class_key', 'method_name'], specify exactly only what method of this class

            'callback'          => 'callable', // optional / call this with specific arguments / as alternative you can use the actions that are inside this function
            'callback_arguments'=> array(), // optional / extra arguments/data for callback
            'wp_option'         => 'option_name' // optional / save options here (update_option(...))
        );

        // Check required options
        if (!isset($arguments['options']))
            die('Undefined required argument "options" in '.__METHOD__.'()');

        $current_ajax = $this->get_current_ajax();

        do {
            if ($current_ajax['type'] === NULL) return;
            // if is some valid ajax, verify if pass the filters
            if ($current_ajax['type'] == 'tf_action')
            {
                if ( isset($arguments['skip_tf_action']) ) {
                    $arguments['skip_tf_action'] = (array)$arguments['skip_tf_action'];
                    if (in_array($current_ajax['callback'], $arguments['skip_tf_action']))
                        return;
                }
                if ( isset($arguments['only_tf_action']) ) {
                    $arguments['only_tf_action'] = (array)$arguments['only_tf_action'];
                    if (!in_array($current_ajax['callback'], $arguments['only_tf_action']))
                        return;
                }
            }
            elseif ($current_ajax['type'] == 'tfuse_ajax')
            {
                $class = end(explode('\\', get_class( $current_ajax['callback'][0] ) ));

                if ( isset($arguments['skip_tfuse_ajax']) ) {
                    $arguments['skip_tfuse_ajax'] = (array)$arguments['skip_tfuse_ajax'];
                    foreach ($arguments['skip_tfuse_ajax'] as $skipClass) {
                        if (is_array($skipClass)) {
                            if ( ($class == $skipClass[0] || $current_ajax['action'] == $skipClass[0])  && $current_ajax['callback'][1] == $skipClass[1] )
                                return;
                        } else {
                            if ( ($class == $skipClass || $current_ajax['action'] == $skipClass) )
                                return;
                        }
                    }
                }
                if ( isset($arguments['only_tfuse_ajax']) ) {
                    $arguments['only_tfuse_ajax'] = (array)$arguments['only_tfuse_ajax'];
                    foreach ($arguments['only_tfuse_ajax'] as $onlyClass) {
                        if (is_array($onlyClass)) {
                            if ( ($class == $onlyClass[0] || $current_ajax['action'] == $onlyClass[0]) && $current_ajax['callback'][1] == $onlyClass[1] )
                                break 2;
                        } else {
                            if ( ($class == $onlyClass || $current_ajax['action'] == $onlyClass) )
                                break 2;
                        }
                    }
                    // Current tfuse_ajax class not found in 'only' filters, but the filters are set, so the class is not allowed
                    return;
                }
            }
        } while(false);

        $options = tf_only_options($arguments['options'],
            array('raw') // leave only types that sure create _POST values
        );
        if (!count($options)){
            echo 'Invalid options given in '.__METHOD__.'(). Only options that sure creates _POST values are allowed (and be sure they are unique enough, a few options in id containing "general"/"not unique" names its not a good idea)'."\n";
            print_r($arguments['options']);
            die();
        }

        // check if _POST contains options
        if (!isset($_POST['options'])) return;

        $post_options   = json_decode($_POST['options']);

        if(!is_object($post_options)) return;

        $post_options_clean_keys = array();
        foreach($post_options as $key=>$val) {
            $post_options_clean_keys[ rtrim($key, '[]') ] = $val;
        }
        // If at least one option is not in _POST, that means the whole array does not match
        if (count($options) > count(array_intersect_key($options, $post_options_clean_keys))) return;

        $values         = get_object_vars($post_options);

        $data_options   = array();
        foreach ($options as $option_id => $option) {
            if ($this->optisave->has_method("admin_{$option['type']}")) {
                $this->optisave->{"admin_{$option['type']}"}($option, $values, $data_options);
            } else {
                $this->optisave->admin_text($option, $values, $data_options);
            }
        }

        if (isset($arguments['wp_option'])) {
            if (empty($arguments['wp_option']))
                die('Argument "wp_option" cannot be empty, in '.__METHOD__.'()');

            update_option($arguments['wp_option'], $data_options);
        }

        $action_arguments = array(
            'current_ajax'      => $current_ajax,
            'raw_options'       => $arguments['options'],
            'data_options'      => $data_options, // Options with data from _POST (key=>value)
            'wp_option'         => ( isset($arguments['wp_option']) ? $arguments['wp_option'] : NULL ),
            'callback_arguments'=> @$arguments['callback_arguments']
        );

        if (isset($arguments['callback'])) {
            if (empty($arguments['callback']))
                die('Argument "callback" cannot be empty, in '.__METHOD__.'()');

            if (is_array($arguments['callback'])) {
                // Object method
                $arguments['callback'][0]->{$arguments['callback'][1]}($action_arguments);
            } else {
                // Function
                $arguments['callback']($action_arguments);
            }
        }

        do_action('tf_ajax_catch_child_options_submit', $action_arguments);

        // md5(serialize($arguments['options'])) - used as unique id for registered options
        do_action('tf_ajax_catch_child_options_submit__'.md5(serialize($arguments['options'])), $action_arguments);

        return $action_arguments;
    }
}