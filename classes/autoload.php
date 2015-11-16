<?php

namespace TidyOutput;

// Register autoloader

spl_autoload_register( function ( $class_name ) {
    $parts = explode( '\\', $class_name, 3 );

    // This autoloader is only for TidyOutput
    if ( $parts[0] != __NAMESPACE__ || count( $parts ) != 2 ) {
        return false;
    }

    $filename = __DIR__ . '/' . $parts[1] . '.php';

    if ( ! file_exists( $filename ) ) {
        return false;
    }

    require_once $filename;

    return class_exists( $class_name, false );
} );
