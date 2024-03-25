<?php

/*
 * Register autoloader for TFUSE framework
 */

spl_autoload_register('tf_autoload');

/*
 * We now define the autoload function, in case we cannot create objects for which classes have not been loaded.
 */

function tf_autoload($class) {
    if (class_exists($class, FALSE))
        return;
    $class = str_replace(TF_PREFIX, '', $class);
    $lookup_dirs = array(TFUSE . '/core/', TFUSE_CHILD . '/specific/');
    foreach ($lookup_dirs as $dir) {
        if (file_exists($dir . $class . '.php')) {
            include($dir . $class . '.php');
            break;
        }
    }
}

/*
 * Set the framework folder path. This is the folder in which the framework is installed.
 */

define('TFUSE', dirname(__FILE__));

/*
 * Load the common functions that are used across the whole framework
 */

require(TFUSE . '/core/Common.php');

/*
 * Load the framework constants
 */

require(TFUSE . '/config/constants.php');

/*
 * Do some magic work and kill magic_quotes (>.<)
 * Also, stripcslashes from GET and POST if magic_quotes is enabled on server
 */
if (get_magic_quotes_runtime()) {
    @set_magic_quotes_runtime(0); // Kill da magic quotes
}
// Remove slashes added by wordpress >.<
remove_wp_magic_quotes();

/*
 * Set time limit to higher value
 */

if (function_exists("set_time_limit") === TRUE && @ini_get("safe_mode") == 0) {
    @set_time_limit(180);
}

/*
 * Initializing the main framework class TFUSE
 */
require_once(TFUSE . '/core/TFUSE.php');
$TFUSE = new TF_TFUSE;

/*
 * Lets load the init classes as defined in $cfg['init_classes']
 */

$init_classes = get_config('init_classes');
foreach ($init_classes as $class_name) {
    __load($class_name);
}

/*
 * Autoload some helpers defined in cfg['init_helpers']
 */

$cfg = get_config('init_helpers');
foreach ($cfg as $helper) {
    include_once(TFUSE . '/helpers/' . strtoupper($helper) . '.php');
}

/*
 * Now the framework has finished loading. 
 * Do some after-loading actions.
 */

$inits = collect_init(NULL, TRUE);
foreach ($inits as $class) {
    $tmp = &__load($class);
    $tmp->__init();
}
unset($inits, $class, $tmp);

/*
 * Load all options we need for our framework from the superglobal $GLOBAL into our massive variable
 */

$tfuse_options = $TFUSE->get->massive();
# Testing area after this line

// The last action executed (alternative to wordpress 'shutdown' action that is executed after die())
// // maybe sometime this will be moved somewhere else,
// // but the logic that this is the 'shutdown' action should remain and can be used by others
add_action('init', '__tf_shutdown_action', 32767);
function __tf_shutdown_action() {
    do_action('tf_shutdown');
}