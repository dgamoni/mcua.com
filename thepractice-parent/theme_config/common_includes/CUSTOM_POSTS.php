<?php
/**
 * Create custom posts types
 *
 * @since The Practice 1.0
 */

if ( !function_exists('tfuse_create_custom_post_types') ) :
/**
 * Retrieve the requested data of the author of the current post.
 *  
 * @param array $fields first_name,last_name,email,url,aim,yim,jabber,facebook,twitter etc.
 * @return null|array The author's spefified fields from the current author's DB object.
 */
    function tfuse_create_custom_post_types()
    {
		//reservation_form
		        $labels = array(
                        'name' => _x('Reservation', 'post type general name', 'tfuse'),
                        'singular_name' => _x('Reservation', 'post type singular name', 'tfuse'),
                        'add_new' => __('Add New', 'tfuse'),
                        'add_new_item' => __('Add New Reservation', 'tfuse'),
                        'edit_item' => __('Edit Reservation info', 'tfuse'),
                        'new_item' => __('New Reservation', 'tfuse'),
                        'all_items' => __('All Reservations', 'tfuse'),
                        'view_item' => __('View Reservation info', 'tfuse'),
                        'parent_item_colon' => ''
                );
                $reservationform_rewrite=apply_filters('tfuse_reservationform_rewrite','reservationform_list');
                $res_args = array(
                                'labels' => $labels,
                                'public' => true,
                                'publicly_queryable' => false,
                                'show_ui' => false,
                                'query_var' => true,
                                'exclude_from_search'=>true,
                                //'menu_icon' => get_template_directory_uri() . '/images/icons/doctors.png',
                                'has_archive' => true,
                                'rewrite' => array('slug'=> $reservationform_rewrite),
                                'menu_position' => 6,
                                'supports' => array(null)
                        );
               register_taxonomy('reservations', array('reservations'), array(
                            'hierarchical' => true,
                            'labels' => array(
                                'name' => _x('Reservation Forms', 'post type general name', 'tfuse'),
                                'singular_name' => _x('Reservation Form', 'post type singular name', 'tfuse'),
                                'add_new_item' => __('Add New Reservation Form', 'tfuse'),
                            ),
                            'show_ui' => false,
                            'query_var' => true,
                            'rewrite' => array('slug' => $reservationform_rewrite)
                        ));
                        register_post_type( 'reservations' , $res_args );

        // CASES
        $labels = array(
            'name' => _x('Cases', 'post type general name', 'tfuse'),
            'singular_name' => _x('Case', 'post type singular name', 'tfuse'),
            'add_new' => __('Add New', 'tfuse'),
            'add_new_item' => __('Add New Case', 'tfuse'),
            'edit_item' => __('Edit Case info', 'tfuse'),
            'new_item' => __('New Case', 'tfuse'),
            'all_items' => __('All Cases', 'tfuse'),
            'view_item' => __('View Case info', 'tfuse'),
            'search_items' => __('Search Cases', 'tfuse'),
            'not_found' =>  __('Nothing found', 'tfuse'),
            'not_found_in_trash' => __('Nothing found in Trash', 'tfuse'),
            'parent_item_colon' => ''
        );

        $caseslist_rewrite = apply_filters('tfuse_caseslist_rewrite','all-cases-list');
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'query_var' => true,
            //'menu_icon' => get_template_directory_uri() . '/images/icons/cases.png',
            'has_archive' => true,
            'rewrite' => array('slug'=> $caseslist_rewrite),
            'menu_position' => 5,
            'supports' => array('title','editor','excerpt','comments')
        );

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name' => _x('Categories', 'taxonomy general name'),
            'singular_name' => _x('Specialty', 'taxonomy singular name'),
            'search_items' => __('Search Specialties'),
            'all_items' => __('All Specialties'),
            'parent_item' => __('Parent Specialty'),
            'parent_item_colon' => __('Parent Specialty:'),
            'edit_item' => __('Edit Specialty'),
            'update_item' => __('Update Specialty'),
            'add_new_item' => __('Add New Specialty'),
            'new_item_name' => __('New Specialty Name')
        );

        $caseslist_taxonomy_rewrite = apply_filters('tfuse_caseslist_taxonomy_rewrite','cases-list');
        register_taxonomy('case_categories', array('cases'), array(
            'hierarchical' => true,
            //'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $caseslist_taxonomy_rewrite)
        ));

        register_post_type( 'cases' , $args );

        // TESTIMONIALS
        $labels = array(
                'name' => _x('Testimonials', 'post type general name', 'tfuse'),
                'singular_name' => _x('Testimonial', 'post type singular name', 'tfuse'),
                'add_new' => __('Add New', 'tfuse'),
                'add_new_item' => __('Add New Testimonial', 'tfuse'),
                'edit_item' => __('Edit Testimonial', 'tfuse'),
                'new_item' => __('New Testimonial', 'tfuse'),
                'all_items' => __('All Testimonials', 'tfuse'),
                'view_item' => __('View Testimonial', 'tfuse'),
                'search_items' => __('Search Testimonials', 'tfuse'),
                'not_found' =>  __('Nothing found', 'tfuse'),
                'not_found_in_trash' => __('Nothing found in Trash', 'tfuse'),
                'parent_item_colon' => ''
        );

        $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'query_var' => true,
                //'menu_icon' => get_template_directory_uri() . '/images/icons/testimonials.png',
                'rewrite' => true,
                'menu_position' => 5,
                'supports' => array('title','editor')
        ); 

        register_post_type( 'testimonials' , $args );

    }
    tfuse_create_custom_post_types();

endif;

add_action('category_add_form', 'taxonomy_redirect_note');
function taxonomy_redirect_note($taxonomy){
    echo '<p><strong>Note:</strong> More options are available after you add the '.$taxonomy.'. <br />
        Click on the Edit button under the '.$taxonomy.' name.</p>';
}
