<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if (!class_exists('Reon')) {
    return;
}

if (!class_exists('WModes_Admin_Product_Options_Panel_Note')) {

    class WModes_Admin_Product_Options_Panel_Note {
        public static function init() {
            add_filter('wmodes-admin/product-options/get-panel-option-fields', array(new self(), 'get_fields'), 10);
        }
        
           public static function get_fields($in_fields) {
            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'fields' => array(                    
                    array(
                        'id' => 'admin_note',
                        'type' => 'textbox',
                        'tooltip' => esc_html__('Adds a private note for reference purposes', 'catalog-mode-pricing-enquiry-forms-promotions'),
                        'column_size' => 1,
                        'column_title' => esc_html__('Admin Note', 'catalog-mode-pricing-enquiry-forms-promotions'),
                        'default' => '',
                        'placeholder' => esc_html__('Type here...', 'catalog-mode-pricing-enquiry-forms-promotions'),
                        'width' => '100%',
                    ),
                ),
            );

            return $in_fields;
        }

    }
    
    WModes_Admin_Product_Options_Panel_Note::init();
}
