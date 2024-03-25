<?php


add_action( 'template_redirect', 'wpse_128636_redirect_post_ipopievent' );

function wpse_128636_redirect_post_ipopievent() {
  $queried_post_type = get_query_var('post_type');
  if ( is_single() && 'odor_reports' ==  $queried_post_type ) {
    wp_redirect( home_url('/odor-reports/') );
    exit;
  }
}