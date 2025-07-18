<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Custom_CSS_Settings' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Custom_CSS_Settings {

        public static function init() {

            $option_name = WModes_Admin_Page::get_option_name();

            add_filter( 'wmodes-admin/get-settings-section-panels', array( new self(), 'get_panel' ), 80 );

            add_filter( 'reon/sanitize-' . $option_name . '-custom_css', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
        }

        public static function get_panel( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'panel',
                'last' => true,
                'white_panel' => false,
                'panel_size' => 'smaller',
                'width' => '100%',
                'field_css_class' => array( 'wmodes_setting_panel' ),
                'merge_fields' => false,
                'fields' => self::get_fields( array() ),
            );

            return $in_fields;
        }

        private static function get_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Style Sheet &amp; Font Icons', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to control the cascaded style sheet (CSS) and font icons', 'catalog-mode-pricing-enquiry-forms-promotions' ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 2,
                'full_width' => true,
                'merge_fields' => false,
                'fields' => self::get_panel_fields( array() ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'full_width' => true,
                'merge_fields' => false,
                'fields' => self::get_custom_css_fields( array() ),
            );

            return $in_fields;
        }

        private static function get_panel_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'use_external_css',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Use External CSS', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines whether or no to use external css', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'no' => esc_html__( 'No', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_custom_css_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'custom_css',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Custom CSS', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Adds additional custom stylesheet to the plugin's components", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'rows' => 5,
                'width' => '100%',
            );

            return $in_fields;
        }

    }

}