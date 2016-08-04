<?php
/**
 * Plugin Name: Facet Stack for FacetWP
 * Plugin URI:  http://cramer.co.za
 * Description: A Widget for creating a stack of styled Facets
 * Version:     1.0.0
 * Author:      David Cramer
 * Author URI:  http://cramer.co.za
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


if ( ! defined( 'WPINC' ) ) {
	die;
}

define('FACET_STACK_PATH', plugin_dir_path(__FILE__));
define('FACET_STACK_URL', plugin_dir_url(__FILE__));
define('FACET_STACK_VER', '1.0.0');
define('FACET_STACK_BASENAME', plugin_basename( __FILE__ ));

// load widget
include_once FACET_STACK_PATH . 'widget.php';