<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Catalog_Mode_Types_Product' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Admin_Catalog_Mode_Types_Product {

        public static function init() {

            $option_name = WModes_Admin_Page::get_option_name();
            $metabox_id = WModes_Admin_Catalog_Mode_MetaBox_Tab::get_metabox_id();

            add_filter( 'wmodes-admin/catalog-modes/get-shop-mode-types', array( new self(), 'get_types' ), 10, 2 );

            add_filter( 'wmodes-admin/catalog-modes/get-mode-type-product-fields', array( new self(), 'get_fields' ), 10, 2 );

            add_filter( 'reon/sanitize-' . $option_name . '-catalog_modes-options-add_to_cart_text', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
            add_filter( 'reon/sanitize-' . $option_name . '-catalog_modes-options-add_to_cart_textblock', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
            add_filter( 'reon/sanitize-' . $option_name . '-catalog_modes-options-price_textblock', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );

            add_filter( 'reon/sanitize-' . $metabox_id . '-wmodes_catalog_modes-options-add_to_cart_text', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
            add_filter( 'reon/sanitize-' . $metabox_id . '-wmodes_catalog_modes-options-add_to_cart_textblock', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
            add_filter( 'reon/sanitize-' . $metabox_id . '-wmodes_catalog_modes-options-price_textblock', array( new WModes_Admin_Page(), 'sanitize_wmodes_kses_post_box' ), 10 );
        }

        public static function get_types( $in_options, $args = array() ) {

            $in_options[ 'product' ] = array(
                'title' => esc_html__( 'Product Page Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
            );

            return $in_options;
        }

        public static function get_fields( $in_fields, $args = array() ) {

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( '"Add to Cart" Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to control "Add to Cart" on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'rn-first', 'wmodes_locations_title' ),
                'fields' => self::get_add_to_cart_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'fields' => self::get_add_to_cart_textblock_fields( $args ),
                'fold' => array(
                    'target' => 'add_to_cart_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( 'Price Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to control price on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_price_fields( $args ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'merge_fields' => false,
                'fields' => self::get_price_textblock_fields( $args ),
                'fold' => array(
                    'target' => 'price_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 3,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( 'Other Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to control variations, stars rating and product tabs visibility on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'wmodes_locations_title' ),
                'fields' => self::get_other_fields( $args ),
            );



            return $in_fields;
        }

        private static function get_add_to_cart_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable_add_to_cart',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( '"Add to Cart" Visibility', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" visibility on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__( 'Show "Add to Cart"', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'hide' => esc_html__( 'Hide "Add to Cart"', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'product_add_to_cart'
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_replace',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Replace With', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" replacement on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'no' => esc_html__( 'Nothing', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'replace_textblock' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'add_to_cart_replace',
                'fold' => array(
                    'target' => 'product_add_to_cart',
                    'attribute' => 'value',
                    'value' => array( 'hide' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_customize',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Customize "Add to Cart"', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" text on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'no',
                'options' => array(
                    'no' => esc_html__( 'No', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'yes' => esc_html__( 'Yes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'add_to_cart_customize',
                'fold' => array(
                    'target' => 'product_add_to_cart',
                    'attribute' => 'value',
                    'value' => array( 'show' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_text',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( '"Add to Cart" Text', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls "Add to Cart" text', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => esc_html__( 'Add to Cart', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'rows' => 1,
                'width' => '100%',
                'fold' => array(
                    'target' => 'add_to_cart_customize',
                    'attribute' => 'value',
                    'value' => array( 'yes' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'add_to_cart_textblock_ui_id',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - UI Design', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the text block's UI design on the product page", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '2234343',
                'data' => 'wmodes:textblock_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'add_to_cart_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_add_to_cart_textblock_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'add_to_cart_textblock',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - Content', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Determines text block's contents", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'rows' => 2,
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function get_price_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable_price',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Price Visibility', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls price visibility on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__( 'Show price', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'hide' => esc_html__( 'Hide price', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'product_price'
            );

            $in_fields[] = array(
                'id' => 'price_replace',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Replace With', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls price replacement on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'no',
                'disabled_list_filter' => 'wmodes-admin/get-disabled-list',
                'options' => array(
                    'no' => esc_html__( 'Nothing', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'replace_textblock' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
                'fold_id' => 'price_replace',
                'fold' => array(
                    'target' => 'product_price',
                    'attribute' => 'value',
                    'value' => array( 'hide' ),
                    'oparator' => 'eq',
                    'clear' => true,
                    'empty' => 'no',
                ),
            );

            $in_fields[] = array(
                'id' => 'prices_textblock_ui_id',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - UI Design', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the text block's UI design on the product page", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '2234343',
                'data' => 'wmodes:textblock_designs',
                'width' => '100%',
                'fold' => array(
                    'target' => 'price_replace',
                    'attribute' => 'value',
                    'value' => array( 'replace_textblock' ),
                    'oparator' => 'eq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_price_textblock_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'price_textblock',
                'type' => 'textarea',
                'column_size' => 1,
                'column_title' => esc_html__( 'Text Block - Content', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Determines text block's contents", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'rows' => 2,
                'width' => '100%',
            );


            return $in_fields;
        }

        private static function get_other_fields( $args ) {

            $in_fields = array();

            $in_fields[] = array(
                'id' => 'enable_variations',
                'type' => 'select2',
                'column_size' => 1,
                'column_title' => esc_html__( 'Variations Visibility', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls variations visibility on product page', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'show',
                'options' => array(
                    'show' => esc_html__( 'Show variations', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'hide' => esc_html__( 'Hide variations', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
            );

            return $in_fields;
        }

    }

    WModes_Admin_Catalog_Mode_Types_Product::init();
}
