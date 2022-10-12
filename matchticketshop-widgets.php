<?php
/**
 * Plugin Name: Matchticketshop widgets
 * Description: Elementor widgets for matchticketshop.com
 * Version:     1.0.0
 * Author:      JorensM
 * Text Domain: matchticketshop-widgets
 */

function register_mts_widgets( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/product-widget.php' );

	$widgets_manager->register( new \Elementor_Product_Widget());

}
add_action( 'elementor/widgets/register', 'register_mts_widgets' );