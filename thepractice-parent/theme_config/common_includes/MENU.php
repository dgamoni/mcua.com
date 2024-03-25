<?php
/**
 * Generate theme menu
 *
 * @since The Practice 1.0
 */

global $menus;


// -----------------------------------------------
register_nav_menus(array(
    'default' => __('Default Navigation', 'tfuse')
));


// -----------------------------------------------
$menus = array(
    'default' => array(
        'depth' => 4,
        'container'       => 'nav',
        'container_id' => 'topmenu',
        'menu_class' => 'dropdown',
        'theme_location' => 'default',
        'fallback_cb' => 'tfuse_select_menu_msg',
        'link_before'     => '<span>',
        'link_after'      => '</span>'
    )
);

// -----------------------------------------------
function tfuse_menu($menu_type) {
    global $menus;
    if (isset($menus[$menu_type])) {
        wp_nav_menu($menus[$menu_type]);
    }
}

function tfuse_select_menu_msg()
{
    echo '<div class="topmenu"><br /><p style="color:black; padding-left:10px;margin-top:-10px;">Please go to the <a href="' . admin_url('nav-menus.php') . '" target="_blanck">Menu</a> section, create a  menu and then select the newly created menu from the Theme Locations box from the left.</p></div>';
}
