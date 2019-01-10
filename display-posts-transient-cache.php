<?php
/**
 * Plugin Name: Display Posts - Transient Cache
 * Plugin URI: https://github.com/billerickson/Display-Posts-Transient-Cache
 * Description: Cache the [display-posts] shortcode output using transients
 * Version: 1.0.0
 * Author: Bill Erickson
 * Author URI: https://www.billerickson.net
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

class BE_DPS_Transient_Cache {

	/**
	 * Primary constructor
	 *
	 */
	function __construct() {

		add_filter( 'pre_display_posts_shortcode_output', array( $this, 'transient_cache' ), 10, 2 );
	}

	/**
	 * Transient Cache
	 *
	 */
	function transient_cache( $output, $atts ) {
		if( empty( $atts['transient_key'] ) || empty( $atts['transient_expiration'] ) )
			return $output;

		$key = $this->transient_key( $atts['transient_key'] );
		$cache = get_transient( $key );

		if( false === $cache ) {
			$expiration = $this->transient_expiration( $atts['transient_expiration'] );
			unset( $atts['transient_key'] );
			unset( $atts['transient_expiration'] );
			$cache = be_display_posts_shortcode( $atts );
			set_transient( $key, $cache, $expiration );
		}

		return $cache;
	}

	/**
	 * Transient Key
	 * Sanitize and prefix with dps_
	 */
	function transient_key( $key ) {
		return 'dps_' . sanitize_key( $key );
	}

	/**
	 * Transient Expiration
	 * Sanitize and convert time constants
	 *
	 */
	function transient_expiration( $string ) {

		$parts = explode( '*', $string );
		if( 1 < count( $parts ) ) {

			// Remove white space
			$parts = array_map( 'trim', $parts );

			// Convert time constants to numbers
			$parts = array_map( array( $this, 'convert_time_constant' ), $parts );

			// Multiply
			$total = array_product( array_map( 'intval', $parts ) );

		} else {
			$total = intval( $string );
		}

		return $total;
	}

	/**
	 * Convert time constant
	 *
	 */
	function convert_time_constant( $string ) {
		return defined( $string ) ? constant( $string ) : $string;
	}

}
new BE_DPS_Transient_Cache;
