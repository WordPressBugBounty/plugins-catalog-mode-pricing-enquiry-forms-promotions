<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

?><div class="<?php echo wp_kses_post(ReonUtil::array_to_classes($box_css)); ?>"<?php echo isset($field['width']) ? ' style="width:' . esc_attr($field['width']) . ';"' : ''; ?><?php echo (isset($field['dyn_field_id'])) ? ' data-dyn_field_id="' . esc_attr($field['dyn_field_id']) . '"' : ''; ?>>                  
    <textarea <?php echo wp_kses_post(ReonUtil::array_to_attributes(apply_filters('reon/control-attributes', $attributes, $field))); ?>><?php echo esc_textarea(isset($field['value']) ? $field['value'] : ''); ?></textarea>                                       
</div> 