<div class="wrap">
    <h1>Tidy Output Settings</h1>

    <p class="description">
        <?php _e( 'These control various HTML output manipulations. Please note'
            . ' that if you are also using a plugin that minimizes your HTML,'
            . ' it is recommended to use only the Cleanup Bad HTML option as'
            . ' the work of the formatters will be reverted by your plugin'
            . ' which is a waste of CPU cycles.', 'tidyoutput' ); ?>
    </p>
<?php if ( count( $methods ) === 1 ): ?>
    <p class="description">
        <?php _e( 'This plugin works best with Tidy, but DOMDocument is also'
            . ' supported. However, you seem to have neither. You\'ll need to'
            . 'install/enable one of these to use the Tidy Output plugin.',
            'tidyoutput' ); ?>
    </p>
<?php else: ?>
<?php if ( ! array_key_exists( 'tidy', $methods ) ): ?>
    <p class="description">
        <?php _e('This plugin works best with Tidy. Some options may be'
            . ' disabled as this library is not installed. You\'ll need to'
            . ' install/enable it to enable the disabled features.',
            'tidyoutput' ); ?>
    </p>
<?php endif; ?>
    <form action="options.php" method="post">
        <?php settings_fields( static::NAME ); ?>
        <?php do_settings_sections( static::NAME ); ?>

        <input name="Submit" class="button button-primary" type="submit"
               value="<?php esc_attr_e( __('Save Changes', 'tidyoutput' ) ); ?>"/>
    </form>
<?php endif; ?>
</div>
