<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Option_Type_Label' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Product_Option_Type_Label {

        public static function init() {

            add_filter( 'wmodes-admin/product-options/get-promotions-option-types', array( new self(), 'get_types' ), 40, 2 );

            add_filter( 'wmodes-admin/product-options/get-option-type-label-fields', array( new self(), 'get_fields' ), 10, 2 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'label' ] = array(
                'title' => esc_html__( 'Product Label', 'catalog-mode-pricing-enquiry-forms-promotions' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => ($args[ 'is_global' ]) ? 8 : 9,
                'merge_fields' => false,
                'field_css_class' => array( 'rn-first' ),
                'fields' => self::get_panel_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'shop',
                'type' => 'columns-field',
                'columns' => ($args[ 'is_global' ]) ? 8 : 9,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => true,
                'title' => esc_html__( 'Shop Loops', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( "Use these settings to control the label's visibility in shop loops", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_shop_panel_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'shop_loop_args',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => true,
                'fields' => self::get_shop_loop_fields( $args ),
                'fold' => array(
                    'target' => 'shop_label_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'single_product',
                'type' => 'columns-field',
                'columns' => ($args[ 'is_global' ]) ? 8 : 9,
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Product Summary', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( "Use these settings to control the label's visibility in product summary area", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'merge_fields' => true,
                'fields' => self::get_product_panel_fields( $args ),
            );

            return $in_fields;
        }

        private static function get_panel_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'mode',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Text Mode', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls what text should be shown as text on the frontend", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'text',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'text' => esc_html__( 'Plain text', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'text',
                'type' => 'textbox',
                'column_size' => 3,
                'column_title' => esc_html__( 'Text', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Enter the text to be shown on the frontend', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'remove_prev',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 2 : 3,
                'column_title' => esc_html__( 'Replace Previous Labels', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines whether or not the previous labels should be removed', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'no' => esc_html__( 'No', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_shop_panel_fields( $args ) {

            $in_fields = array();


            $in_fields[] = array(
                'id' => 'enable',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 2 : 3,
                'column_title' => esc_html__( 'Show In Shop Loops', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines whether or not the label should be shown in shop loops', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'yes',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'no' => esc_html__( 'No', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'shop_label_enable',
            );



            $in_fields[] = array(
                'id' => 'location',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Shop Loops - Location', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the label's location in the shop loops", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'data' => 'wmodes:view_locations:shop',
                'width' => '100%',
                'fold' => array(
                    'target' => 'shop_label_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'ui_id',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Shop Loops - UI Design', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the label's UI design in the shop loops", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '2234343',
                'data' => 'wmodes:label_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'shop_label_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_shop_loop_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'loops',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 3 : 2,
                'column_title' => esc_html__( 'Shop Loops', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines which of the shop loops the label should be visible in', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => array(),
                'multiple' => true,
                'minimum_results_forsearch' => 10,
                'placeholder' => esc_html__( 'Select shop loops', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => WModes_Admin_Product_Option_Types::get_shop_loop_types( $args ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'compare',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 1 : 2,
                'column_title' => esc_html__( 'Equals To', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Determines how to validate the shop loops for the label's visibility", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'in_list',
                'options' => array(
                    'in_list' => esc_html__( 'Any in the list', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'none' => esc_html__( 'Any NOT in the list', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_product_panel_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable',
                'type' => 'select2',
                'column_size' => ($args[ 'is_global' ]) ? 2 : 3,
                'column_title' => esc_html__( 'Show In Product Summary', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines whether or not the label should be shown in product summary area', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'no',
                'options' => array(
                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'no' => esc_html__( 'No', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'product_label_enable',
            );

            $in_fields[] = array(
                'id' => 'location',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Product Summary - Location', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the label's location in the product summary area", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'data' => 'wmodes:view_locations:single-product',
                'width' => '100%',
                'fold' => array(
                    'target' => 'product_label_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'ui_id',
                'type' => 'select2',
                'column_size' => 3,
                'column_title' => esc_html__( 'Product Summary - UI Design', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the label's UI design in the single product summary area", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '2234343',
                'data' => 'wmodes:label_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'product_label_enable',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

    }

    WModes_Admin_Product_Option_Type_Label::init();
}