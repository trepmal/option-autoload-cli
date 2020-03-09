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

		wp_protect_special_option( $option );

		global $wpdb;
		$option_exists = $wpdb->get_var( $wpdb->prepare( "SELECT option_id from {$wpdb->options} where option_name = %s", $option ) );

		if ( is_null( $option_exists ) ) {
			WP_CLI::error( "Option does not exist" );
		}

		$option_updated = $wpdb->get_results( $wpdb->prepare( "UPDATE {$wpdb->options} SET autoload = %s where option_name = %s", $yn, $option ) );

		wp_cache_delete( 'alloptions', 'options' );

		// @todo make better :)
		WP_CLI::success( 'Done.' );

	}

	/**
	 * Option Autoload
	 *
	 * ## OPTIONS
	 *
	 * <option>
	 * : Name of option
	 *
	 * ## EXAMPLES
	 *
	 *     wp option autoload get debug-thing
	 */
	function get( $args, $assoc_args ) {

		list( $option ) = $args;

		global $wpdb;
		$option_exists = $wpdb->get_var( $wpdb->prepare( "SELECT autoload from {$wpdb->options} where option_name = %s", $option ) );

		if ( is_null( $option_exists ) ) {
			WP_CLI::error( "Option does not exist" );
		}

		// @todo, fancy output using --format flag
		echo $option_exists;

	}

	/**
	 * Option Autoload
	 *
	 * ## OPTIONS
	 *
	 * [<yn>]
	 * : yes or no
	 * ---
	 * default: yes
	 * options:
	 *   - yes
	 *   - no
	 * ---
	 *
	 * [--format=<format>]
	 * : Format to use for the output. One of table, csv or json.
	 *
	 * ## EXAMPLES
	 *
	 *     wp option autoload list
	 *
	 * @subcommand list
	 */
	function list_( $args, $assoc_args ) {

		list( $yn ) = $args;
		$yn = true === $yn ? 'yes' : $yn; // if <yn> isn't set, it becomes 'true' (not sure if bug?)

		global $wpdb;
		$options = $wpdb->get_results( $wpdb->prepare( "SELECT option_name from {$wpdb->options} where autoload = %s", $yn ) );

		$formatter = new \WP_CLI\Formatter( $assoc_args, array( 'option_name' ), 'autoloaded_options' );
		$formatter->display_items( $options );

	}

	/**
	 * Option Autoload
	 *
	 * ## OPTIONS
	 *
	 * ## EXAMPLES
	 *
	 *     wp option autoload refresh
	 *
	 */
	function refresh( $args, $assoc_args ) {

		WP_CLI::run_command( array( 'cache', 'delete', 'alloptions', 'options' ) );
		return;

	}
}