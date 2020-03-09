<?php
/**
 * Scrub Posts
 */
class Option_Autoload extends WP_CLI_Command {

	/**
	 * Option Autoload
	 *
	 * ## OPTIONS
	 *
	 * <option>
	 * : Name of option
	 *
	 * <yn>
	 * : yes or no
	 * ---
	 * default: no
	 * options:
	 *   - yes
	 *   - no
	 * ---
	 *
	 *
	 * ## EXAMPLES
	 *
	 *     wp option autoload set debug-thing no
	 */
	function set( $args, $assoc_args ) {

		list( $option, $yn ) = $args;

		global $wpdb;
		$option_exists = $wpdb->get_var( $wpdb->prepare( "SELECT option_id from {$wpdb->options} where option_name = %s", $option ) );

		if ( false === $option_exists ) {
			WP_CLI::error( "Option does not exist" );
		}

		$option_updated = $wpdb->get_results( $wpdb->prepare( "UPDATE {$wpdb->options} SET autoload = %s where option_name = %s", $yn, $option ) );

		wp_cache_delete( 'alloptions', 'options' );

	}

	/**
	 * Option Autoload
	 *
	 * ## OPTIONS
	 *
	 * <option>
	 * : Name of option
	 *
	 *
	 * ## EXAMPLES
	 *
	 *     wp option autoload get debug-thing
	 */
	function get( $args, $assoc_args ) {

		list( $option ) = $args;

		global $wpdb;
		$option_exists = $wpdb->get_var( $wpdb->prepare( "SELECT autoload from {$wpdb->options} where option_name = %s", $option ) );

		if ( false === $option_exists ) {
			WP_CLI::error( "Option does not exist" );
		}

		// @todo, fancy output using --format flag
		echo $option_exists;

	}
}