<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Sale_Query_Settings' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Sale_Query_Settings {

        public static function init() {

            add_filter( 'wmodes-admin/get-settings-section-panels', array( new self(), 'get_panel' ), 60 );
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

            $allow_html =  WModes_Main::get_allow_html();
            
            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'On-Sale Products Query', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => wp_kses( __( 'Use this panel to control on-sale products query settings, use <a href="https://docs.woocommerce.com/document/woocommerce-shortcodes/" target="_blank">WooCommerce shortcodes</a> to display your products', 'catalog-mode-pricing-enquiry-forms-promotions' ), $allow_html ),
            );

            $in_fields[] = array(
                'id' => 'product_query',
                'type' => 'columns-field',
                'columns' => 9,
                'merge_fields' => true,
                'fields' => self::get_panel_fields(),
            );

            return $in_fields;
        }

        private static function get_panel_fields() {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Enable', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Enables on-sale products query', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => array( 'no' ),
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'no' => esc_html__( 'No', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'enable_on_sale',
            );

            $in_fields[] = array(
                'id' => 'query_limit',
                'type' => 'textbox',
                'input_type' => 'number',
                'column_size' => 2,
                'column_title' => esc_html__( 'Number of Products', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines the maximum total number of the query result', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '50',
                'placeholder' => esc_html__( '0.00', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
                'fold' => array(
                    'target' => 'enable_on_sale',
                    'attribute' => 'value',
                    'value' => 'yes',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'cache_duration',
                'type' => 'textbox',
                'input_type' => 'number',
                'column_size' => 2,
                'column_title' => esc_html__( 'Cache Duration', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines the cache duration of the query result in minutes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '30',
                'placeholder' => esc_html__( '0.00', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'attributes' => array(
                    'min' => '0',
                    'step' => '1',
                ),
                'fold' => array(
                    'target' => 'enable_on_sale',
                    'attribute' => 'value',
                    'value' => 'yes',
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Sale_Query_Settings::init();
}