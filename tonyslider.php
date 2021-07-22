<?php
/**
* Plugin Name: Tony Slider
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Elroi
* Author URI: http://yourwebsiteurl.com/
* Domain Path: /languages
**/

function tonys_load_textdomain() {
	load_plugin_textdomain( 'tonyslider', false, dirname( __FILE__ ) . "/languages" );
}

add_action( 'plugins_loaded', 'tonys_load_textdomain' );

function tonys_init() {
	add_image_size( 'tony-slider', 800, 600, true );
}

add_action( 'init', 'tonys_init' );

function tonys_assets() {
	wp_enqueue_style( 'tonyslider-css', plugin_dir_url( __FILE__ ) . 'assets/tony-slider.css',array(),'1.1','all');
	wp_enqueue_script( 'tonyslider-js', plugin_dir_url( __FILE__ ) . 'assets/tony-slider.js', array ( 'jquery' ), 1.1, true);
	wp_enqueue_script( 'tonyslider-main-js', plugin_dir_url( __FILE__ ) . "assets/js/main.js", array( 'jquery' ), '1.0', true );
}

add_action( 'wp_enqueue_scripts', 'tonys_assets' );

function tonys_shortcode_tslider( $atts, $content ) {
	$defaults = array(
		'width'  => 800,
		'height' => 600,
		'id'     => ''
	);

	$attributes = shortcode_atts( $defaults, $atts );
	$content    = do_shortcode( $content );

	$shortcode_output = <<<EOD
							<div id="{$attributes['id']}" style="width: {$attributes['width']}; height: {$attributes['height']}">
								<div class="ts-slider">
									{$content}
								</div>
							</div>
						EOD;

	return $shortcode_output;

}

add_shortcode( 'tslider', 'tonys_shortcode_tslider' );

function tonys_shortcode_tslide( $atts ) {
	$defaults   = array(
		'caption' => '',
		'id'      => '',
		'size'    => 'large'
	);
	$attributes = shortcode_atts( $defaults, $atts );

	$image_src = wp_get_attachment_image_url( $attributes['id'], $attributes['size'] );

	$option_output = <<<EOD
							<div class="slide">
								<p><img src="{$image_src}" alt="{$attributes['caption']}"></p>
								<p>{$attributes['caption']}</p>
							</div>
						EOD;

	return $option_output;

}

add_shortcode( 'tslide', 'tonys_shortcode_tslide' );