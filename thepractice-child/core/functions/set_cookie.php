<?php

add_action( 'init', 'set_agent_cookie' );

function set_agent_cookie() {
    //if( is_post_type_archive( 'odor_reports' ) ) : 
            $name = 'odor_reports_ref';
            $expires = time() + 3600;
            if (isset($_GET['ref'])) {
                $value = $_GET['ref'];
                setcookie($name, $value, $expires, '/', 'www.mcua.com');
            }
    //endif;       
} 