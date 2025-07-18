<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Product_Options_MetaBox_Global' ) ) {

    class WModes_Admin_Product_Options_MetaBox_Global {

        public static function init() {
            add_filter( 'wmodes-admin/product-options/get-metabox-fields', array( new self(), 'get_metabox_fields' ), 10, 2 );
        }

        public static function get_metabox_fields( $in_fields, $product_id ) {

            $in_fields[] = array(
                'id' => 'wmodes_product_options_settings',
                'type' => 'panel',
                'white_panel' => false,
                'panel_size' => 'smaller',
                'width' => '100%',
                'css_class' => array( 'wmodes_mbx_global' ),
                'last' => true,
                'fields' => array(
                    array(
                        'id' => 'any_id',
                        'type' => 'columns-field',
                        'columns' => 7,
                        'merge_fields' => false,
                        'fields' => array(
                            array(
                                'id' => 'enable',
                                'type' => 'select2',
                                'column_size' => 2,
                                'column_title' => esc_html__( 'Product Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'tooltip' => esc_html__( 'Enables product settings on this product', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'default' => 'all',
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'options' => array(
                                    'global' => esc_html__( 'Use global settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                    'yes' => esc_html__( 'Enabled', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                ),
                                'width' => '100%',
                                'fold_id' => 'enable_product_options',
                            ),
                            array(
                                'id' => 'override_global',
                                'type' => 'select2',
                                'column_size' => 2,
                                'column_title' => esc_html__( 'Override global settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'tooltip' => esc_html__( 'Overrides global product option settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'default' => 'yes',
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'options' => array(
                                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                ),
                                'width' => '100%',
                                'fold' => array(
                                    'target' => 'enable_product_options',
                                    'attribute' => 'value',
                                    'value' => 'yes',
                                    'oparator' => 'eq',
                                    'clear' => false,
                                ),
                            ),
                            array(
                                'id' => 'mode',
                                'type' => 'select2',
                                'column_size' => 3,
                                'column_title' => esc_html__( 'Apply Mode', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'tooltip' => esc_html__( 'Controls product settings apply method', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                                'default' => 'all',
                                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                                'options' => self::get_apply_method(),
                                'width' => '100%',
                                'fold' => array(
                                    'target' => 'enable_product_options',
                                    'attribute' => 'value',
                                    'value' => 'yes',
                                    'oparator' => 'eq',
                                    'clear' => false,
                                ),
                            ),
                        ),
                    ),
                ),
            );

            return $in_fields;
        }

        private static function get_apply_method() {

            $apply_methods = array(
                'all' => esc_html__( 'Apply all valid product settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
            );

           

            $apply_methods = apply_filters( 'wmodes-admin/product-options/get-apply-methods', $apply_methods );

            return $apply_methods;
        }

    }

    WModes_Admin_Product_Options_MetaBox_Global::init();
}