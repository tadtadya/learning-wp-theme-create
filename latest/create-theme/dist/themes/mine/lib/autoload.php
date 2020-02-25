<?php

require_once trailingslashit( get_stylesheet_directory() ) . 'lib/classes/class-autoloader.php';

use Mine\Autoloader as Mine_Autoloader;

/**
 * WordPress用クラスオートローダ
 */
spl_autoload_register( function ( $class_name ) {
	$base_path = trailingslashit( get_stylesheet_directory() ) . 'lib/classes';

	$loader = Mine_Autoloader::get_instance();
	$loader->wordpress( $class_name, $base_path, false );
});
