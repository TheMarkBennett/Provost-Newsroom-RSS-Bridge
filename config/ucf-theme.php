<?php
/*
* The UCF wordpress theme deactivates rss feed. This will turn it back on
* This taken from UCF Today https://github.com/UCF/Today-Child-Theme/blob/master/includes/config.php#L83-L131
*/


/**
 * Disable the UCF WP Theme's template redirect overrides.
 */


function remove_theme_redirects() {

    remove_action( 'template_redirect', 'ucfwp_kill_unused_templates' );

}
add_action( 'after_setup_theme', 'remove_theme_redirects');


/**
 * Kill unused templates in this theme.  Redirect to the homepage if
 * an unused template is requested.
 */

function athena_kill_unused_templates() {

	global $wp_query, $post;

  if ( is_author() || is_attachment() || is_day() || is_year() || is_search() || is_comment_feed() ) {
  		wp_redirect( home_url() );
  		exit();
  	}

}

add_action( 'template_redirect', 'athena_kill_unused_templates' );
