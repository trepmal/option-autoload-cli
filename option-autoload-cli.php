<?php

if ( ! defined( 'WP_CLI' ) ) return;

require_once __DIR__ . '/inc/class-option-autoload.php';

WP_CLI::add_command( 'option autoload', 'Option_Autoload' );
