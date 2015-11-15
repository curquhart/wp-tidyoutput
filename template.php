<?php

// Make sure WP_USE_THEMES is defined, to ensure this isn't being called
// directly

if ( defined( 'WP_USE_THEMES' ) && WP_USE_THEMES ) {
    // Get TidyOutput instance. While it would be better to do all of this from
    // one method, if we did so then the template wouldn't have access to any
    // globals.

    $instance = TidyOutput::get_instance();

    // Get template filename
    $template = $instance->get_template_filename();

    // Start capturing output so we can reformat it
    $instance->begin_output_capture();

    // Cleanup. We don't want the template to have access to $instance unless
    // it accesses it explicitly for some reason (via TidyOutput::get_instance).
    // Plus if the template overwrites it we'll have to fetch it again anyway,
    // assuming it doesn't destroy it since it's by reference.
    unset( $instance );

    // Include template. Note that there is no need to validate this because
    // the file comes directly from WP's template_include hook.
    include $template;

    // Stop capturing output. This is also responsible for formatting the HTML.
    TidyOutput::get_instance()->end_output_capture();
}
