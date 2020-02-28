<?php
/**
 * Plugin Name:       Provost Newsroom Connector
 * Plugin URI:        https://provost.ucf.edu
 * Description:       This works with the UCF Athena theme and creates a rss feed for the provost newsroom
 * Version:           0.00.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mark Bennett
 * Author URI:        https://provost.ucf.edu
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
  */




 /*
*
*Gets the current themes information to determine if it's the athena theme or child theme.
*
 */
 $current_Theme = get_template('Template');

 if ( 'UCF-WordPress-Theme' == $current_Theme ):

   require_once( plugin_dir_path( __FILE__ ) . 'config/ucf-theme.php' );

endif;


/*
* Adds ACF to post
*/
require_once( plugin_dir_path( __FILE__ ) . 'config/acf-fields.php' );


/*
rss feed configuration
*/
require_once( plugin_dir_path( __FILE__ ) . 'config/rss-feed.php' );
