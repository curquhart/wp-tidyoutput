<?php

define('TIDYOUTPUT_JS_CACHE_MINUTES', 60);

// Calculate time in the future
$datetime = DateTime::createFromFormat( 'U',
    time() + 60 * TIDYOUTPUT_JS_CACHE_MINUTES,
    new DateTimeZone( 'GMT' ) );

// Send headers
header( 'Content-Type: application/javascript' );
header( 'Cache-Control: max-age=' . ( 60 * TIDYOUTPUT_JS_CACHE_MINUTES ) );
header( 'Expires: ' . $datetime->format( DateTime::RFC1123 ) );

// Cleanup
unset( $datetime );

// Require class
require __DIR__ . '/../classes/TidyOutput.php';

?>

(function ($, document) {
    "use strict";

    // Datas
    var methods = <?= json_encode( array_values(
        TidyOutput::get_instance()->get_available_methods() ) ); ?>;
    var method_id = <?= json_encode( '#' . TidyOutput::NAME . '_'
        . TidyOutput::TIDY_METHOD); ?>;
    var full_page_id = <?= json_encode( '#' . TidyOutput::NAME . '_'
        . TidyOutput::FULL_PAGE); ?>;
    var cleanup_id = <?= json_encode( '#' . TidyOutput::NAME . '_'
        . TidyOutput::CLEANUP); ?>;
    var format_id = <?= json_encode( '#' . TidyOutput::NAME . '_'
        . TidyOutput::FORMAT); ?>;

    var validateSupport = function () {
        var active = $(method_id).val();
        var activeObject = null;

        // Find the selected method
        $.each(methods, function(index, method) {
            if (method.name === active) {
                activeObject = method;

                // Break out of the loop
                return false;
            }

            return true;
        });

        // Default to no support for anything
        var cleanSupport = false;
        var formatSupport = false;

        // Make sure a legit option is selected.
        if (activeObject !== null) {
            cleanSupport = $.inArray("<?= htmlspecialchars( TidyOutput::CLEANUP, ENT_COMPAT, 'UTF-8' ); ?>", activeObject.supports) !== -1;
            formatSupport = $.inArray("<?= htmlspecialchars( TidyOutput::FORMAT, ENT_COMPAT, 'UTF-8' ); ?>", activeObject.supports) !== -1;
        }

        // Set disabled prop based on support
        $(cleanup_id).prop('disabled', !cleanSupport);
        $(format_id).prop('disabled', !formatSupport);
        $(full_page_id).prop('disabled', !cleanSupport && !formatSupport);
    };

    $(document).ready(function () {
        // Call once on docready
        validateSupport();

        // Call again whenever the option is changed
        $(method_id).change(validateSupport);
    });

})(jQuery, document);
