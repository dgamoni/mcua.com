<?php
if ( ! function_exists('cpt_odor_reports') ) {

// Register Custom Post Type
function cpt_odor_reports() {

	$labels = array(
		'name'                  => _x( 'Odor Reports', 'Odor Reports', 'mcua' ),
		'singular_name'         => _x( 'Odor Reports', 'Odor Reports', 'mcua' ),
		'menu_name'             => __( 'Odor Reports', 'mcua' ),
		'name_admin_bar'        => __( 'Odor Reports', 'mcua' ),
		'archives'              => __( 'Item Archives', 'mcua' ),
		'attributes'            => __( 'Item Attributes', 'mcua' ),
		'parent_item_colon'     => __( 'Parent Item:', 'mcua' ),
		'all_items'             => __( 'All Items', 'mcua' ),
		'add_new_item'          => __( 'Add New Item', 'mcua' ),
		'add_new'               => __( 'Add New', 'mcua' ),
		'new_item'              => __( 'New Item', 'mcua' ),
		'edit_item'             => __( 'Edit Item', 'mcua' ),
		'update_item'           => __( 'Update Item', 'mcua' ),
		'view_item'             => __( 'View Item', 'mcua' ),
		'view_items'            => __( 'View Items', 'mcua' ),
		'search_items'          => __( 'Search Item', 'mcua' ),
		'not_found'             => __( 'Not found', 'mcua' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'mcua' ),
		'featured_image'        => __( 'Featured Image', 'mcua' ),
		'set_featured_image'    => __( 'Set featured image', 'mcua' ),
		'remove_featured_image' => __( 'Remove featured image', 'mcua' ),
		'use_featured_image'    => __( 'Use as featured image', 'mcua' ),
		'insert_into_item'      => __( 'Insert into item', 'mcua' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'mcua' ),
		'items_list'            => __( 'Items list', 'mcua' ),
		'items_list_navigation' => __( 'Items list navigation', 'mcua' ),
		'filter_items_list'     => __( 'Filter items list', 'mcua' ),
	);
	$args = array(
		'label'                 => __( 'Odor Reports', 'mcua' ),
		'description'           => __( 'Odor Reports Description', 'mcua' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'menu_icon'   			=> 'dashicons-list-view',
	);
	register_post_type( 'odor_reports', $args );

}
add_action( 'init', 'cpt_odor_reports', 0 );

} 