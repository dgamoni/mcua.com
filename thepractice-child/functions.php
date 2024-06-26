<?php


// --------- core load

define('CORE_PATH', get_stylesheet_directory() . '/core');
define('CORE_URL', get_stylesheet_directory_uri()  . '/core');
// define( 'CORE_PLUGINS_PATH', CORE_PATH . '/plugins/' );
// define( 'CORE_PLUGINS_URL', CORE_URL . '/plugins/' );

$dirs = array(
    CORE_PATH . '/post_types/',
    CORE_PATH . '/functions/',
);
foreach ($dirs as $dir) {
    $other_inits = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (false !== ($file = readdir($dh))) {
                if ($file != '.' && $file != '..' && stristr($file, '.php') !== false) {
                    list($nam, $ext) = explode('.', $file);
                    if ($ext == 'php')
                        $other_inits[] = $file;
                }
            }
            closedir($dh);
        }
    }
    asort($other_inits);
    foreach ($other_inits as $other_init) {
        if (file_exists($dir . $other_init))
            include_once $dir . $other_init;
    }
}

//require_once CORE_PLUGINS_PATH. 'init.php';
//require_once CORE_PATH.'/lib/BFI_Thumb.php';

// --------- end core load

add_action('wp_footer', 'add_custom_css');
function add_custom_css() { ?>

    <?php if( is_post_type_archive( 'odor_reports' ) ) : ?>

        <script>
            jQuery(document).ready(function($) {
    
                function getCookie(key) {
                    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
                    return keyValue ? keyValue[2] : null;
                }
                console.log('readCookie: '+ getCookie('odor_reports_ref') );
                if ( getCookie('odor_reports_ref').length > 0 ) {
                    //$('.archive_odor_reports_template #topmenu .dropdown .current-menu-ancestor.' + getCookie('odor_reports_ref') + ' > a').css('color', '#5eae00');
                    $('#topmenu .dropdown li.' + getCookie('odor_reports_ref') + ' > a').css('color', '#5eae00');
                }

            });
        </script>

    <?php endif; ?>

    <style>

    </style>
    <?php
}

