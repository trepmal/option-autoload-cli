<?php
/**
 * Manage autoloaded options
 */
class Option_Autoload extends WP_CLI_Command {

	/**
	 * Set autoload for option
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
		$option_autoload = $wpdb->get_var( $wpdb->prepare( "SELECT autoload from {$wpdb->options} where option_name = %s", $option ) );

		if ( is_null( $option_autoload ) ) {
			WP_CLI::error( "Option does not exist" );
		}

		if ( $option_autoload === $yn ) {
			WP_CLI::error( sprintf( "Option autoload already set to %s", $yn ) );
		}

		$option_updated = $wpdb->get_results( $wpdb->prepare( "UPDATE {$wpdb->options} SET autoload = %s where option_name = %s", $yn, $option ) );

		$check_option = $wpdb->get_var( $wpdb->prepare( "SELECT autoload from {$wpdb->options} where option_name = %s", $option ) );

		if ( $check_option === $option_autoload ) {
			WP_CLI::error( "Option not updated" );
		}

		$alloptions_before = wp_cache_get( 'alloptions', 'options' );
		wp_cache_delete( 'alloptions', 'options' );
		wp_load_alloptions(); // populate cache
		$alloptions_after = wp_cache_get( 'alloptions', 'options' );

		$cache_success = false;
		switch ( $check_option ) {
			case 'no' :
				$cache_success = ( isset( $alloptions_before[ $option ] ) )  && ( ! isset( $alloptions_after[ $option ] ) );
			break;
			case 'yes' :
				$cache_success = ( ! isset( $alloptions_before[ $option ] ) )  && ( isset( $alloptions_after[ $option ] ) );
			break;
		}

		WP_CLI::success( sprintf(
			'Autoload changed.%s',
			WP_CLI::colorize( $cache_success ? ' Cache flushed.' : ' %rCache flush failed%n' )
		) );

	}

	/**
	 * Get autoload for option
	 *
	 * ## OPTIONS
	 *
	 * <option>
	 * : Name of option
	 *
	 * [--format=<format>]
	 * : Format to use for the output. One of table, csv or json.
	 *
	 * ## EXAMPLES
	 *
	 *     wp option autoload get debug-thing
	 */
	function get( $args, $assoc_args ) {

		list( $option ) = $args;

		global $wpdb;
		$option_autoload = $wpdb->get_var( $wpdb->prepare( "SELECT autoload from {$wpdb->options} where option_name = %s", $option ) );

		if ( is_null( $option_autoload ) ) {
			WP_CLI::error( "Option does not exist" );
		}

		WP_CLI::print_value( $option_autoload, $assoc_args );

	}

	/**
	 * List all autoloaded (or not) options
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
	 * Refresh alloptions cache
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