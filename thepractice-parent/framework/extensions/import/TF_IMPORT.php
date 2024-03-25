<?php

if (!defined('TFUSE'))
    wp_die(__('Direct access forbidden.', 'tfuse'));

/**
 * Description of IMPORT
 *
 */
class TF_IMPORT extends TF_TFUSE {

    public $_the_class_name = 'IMPORT';

    function __construct() {
        parent::__construct();
    }

    function __init() {

        if (isset($_REQUEST['install_demo']) && $_REQUEST['install_demo'] == 'no') 
            update_option( TF_THEME_PREFIX . '_tfuse_framework_options',array('install_demo'=>'no') );

        if (get_option(TF_THEME_PREFIX . '_tfuse_framework_options')) {} else
        add_action('admin_menu', array(&$this, 'add_menu'), 20);
    }
    
    function add_menu() {
        add_submenu_page('themefuse', 'Import', 'Import', 'manage_options', 'tf_import', array(&$this, 'import'));
    }
    
    function import() {
        // include importer file parsers
        if ( ! defined( 'WP_LOAD_IMPORTERS' ) )
            define('WP_LOAD_IMPORTERS', true);
        require_once dirname( __FILE__ ) . '/wordpress-importer/wordpress-importer.php';
        require_once dirname( __FILE__ ) . '/TFUSE_WP_IMPORT.php';
        
        $tfuse_import = new TFUSE_WP_IMPORT();
        $tfuse_import->dispatch();
    }
    
}