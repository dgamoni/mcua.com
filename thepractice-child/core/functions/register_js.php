<?php

function odor_reports_scripts_child() {

	// wp_register_script( 'ipopi-function-child-js', CORE_URL . '/js/function-child.js', array( 'jquery' ), '2', true );
	// wp_enqueue_script( 'ipopi-function-child-js');

	wp_register_style('listing_table_css', CORE_URL .'/css/listing_table.css', array(),null, 'all');
	wp_enqueue_style('listing_table_css');

	wp_register_style('odor_reports_css', CORE_URL .'/css/odor_reports.css', array(),null, 'all');
	wp_enqueue_style('odor_reports_css');

}
add_action( 'wp_enqueue_scripts', 'odor_reports_scripts_child', 101 );

