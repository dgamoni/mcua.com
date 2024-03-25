<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');
/*
 * This is the main class. Super Class :D
 */

class TF_TFUSE {

    private static $instance = NULL;
    public $framework_version = '2.2.14';
    public static $_core_instances = array();
    static $_restricted_names;
    public $__parent;

    public function __construct() {
        if (self::$instance === NULL) {
            self::$instance = & $this;
            self::$_restricted_names = get_config('restricted_names');
        }
        foreach (self::$_restricted_names as $property_name)
            if (property_exists($this, $property_name))
                die('Property ' . $property_name . ' not allowed in class: ' . $this->_the_class_name);
        if (property_exists($this, '_the_class_name')) {
            $this->__autoload();
            if (method_exists($this, '__init')) {
                collect_init($this->_the_class_name);
            }
        }
    }

    public static function &get_instance() {
        return self::$instance;
    }

    function __load_massive() {
        if (!(property_exists($this, '_standalone') && $this->_standalone)) {
            //__load_instance_in_massive($this->_the_class_name, $this);
            if (!array_key_exists(strtolower($this->_the_class_name), self::$_core_instances))
                self::$_core_instances[strtolower($this->_the_class_name)] = &$this;
        }
    }

    function __autoload() {
        $this->__load_massive();
    }

    public static function &magic_get($name) {
        if (array_key_exists($name, self::$_core_instances)) {
            return self::$_core_instances[$name];
        }
        else
            return NULL;
    }

    function __get($name) {
        if (array_key_exists($name, self::$_core_instances)) {
            return self::$_core_instances[$name];
        }
        else
            return NULL;
    }
}
