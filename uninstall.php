<?php

// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die();
}

require __DIR__ . '/classes/autoload.php';

// Initialize without attaching to WordPress
TidyOutput::get_instance()->uninstall();
