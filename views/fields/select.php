<select id="<?php esc_attr_e( static::NAME ); ?>_<?php esc_attr_e( $field ); ?>"
        name="<?php esc_attr_e( static::NAME ); ?>[<?php esc_attr_e( $field ); ?>]">
<?php foreach ( $values as $value ): ?>
    <option <?= $options[ $field ] == $value['name'] ? 'selected="selected"' : ''; ?>
        value="<?php esc_attr_e( $value['name'] ); ?>"><?php esc_html_e( __( $value['title'], 'tidyoutput' ) ); ?></option>
<?php endforeach; ?>
</select>
<?php if ( ! empty( $description ) ): ?>
<p class="description">
         <?= $description; ?>
</p>
<?php endif; ?>
