<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Options_MetaBox_Panel_Note' ) ) {

    class WModes_Admin_Product_Options_MetaBox_Panel_Note {

        public static function init() {
            add_filter( 'wmodes-admin/product-options/get-mbx-panels', array( new self(), 'get_panel' ), 1, 2 );
        }

        public static function get_panel( $in_fields, $product_id ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'panel',
                'full_width' => true,
                'center_head' => true,
                'white_panel' => true,
                'panel_size' => 'smaller',
                'width' => '100%',
                'last' => true,
                'css_class' => array( 'wmodes-padded-panel' ),
                'merge_fields' => false,
                'fields' => array(
                    array(
                        'id' => 'any_id',
                        'type' => 'columns-field',
                        'columns' => 1,
                        'merge_fields' => false,
                        'fields' => array(
                            array(
                                'id' => 'admin_note',
                                'type' => 'textbox',
                                'tooltip' => esc_html__( 'Adds a private note for reference purposes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'column_size' => 1,
                                'column_title' => esc_html__( 'Admin Note', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'default' => '',
                                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'width' => '100%',
                            ),
                        ),
                    ),
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Product_Options_MetaBox_Panel_Note::init();
}