<?php

namespace TidyOutput;

// Require autoloader
require __DIR__ . '/../classes/autoload.php';

// Get TidyOutput instance. This (by default) won't try to attach to (unloaded)
// WordPress
$instance = TidyOutput::get_instance();

// Send applicable JavaScript headers
$instance->send_javascript_headers();

// Get available tidying methods
$methods = $instance->get_available_methods();

?>

(function ($, document) {
    "use strict";

    // Datas
    var methods = <?= json_encode( array_values( $methods ) ); ?>;
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
