<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}


if ( !class_exists( 'WModes_Admin_Logic_Types_Taxonomy' ) ) {

    class WModes_Admin_Logic_Types_Taxonomy {

        private static $instance;
        private $taxonomies;

        public static function get_instance(): self {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function get_taxonomies() {

            if ( !is_null( $this->taxonomies ) ) {

                return $this->taxonomies;
            }

            $this->taxonomies = array();

            $this->taxonomies[ 'product_cat' ] = array(
                'label_singular' => esc_html__( 'Category', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'label_plural' => esc_html__( 'Categories', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'label_field' => esc_html__( 'Product Categories', 'catalog-mode-pricing-enquiry-forms-promotions' )
            );

            $this->taxonomies[ 'product_tag' ] = array(
                'label_singular' => esc_html__( 'Tag', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'label_plural' => esc_html__( 'Tags', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'label_field' => esc_html__( 'Product Tags', 'catalog-mode-pricing-enquiry-forms-promotions' )
            );
        }

    }

}