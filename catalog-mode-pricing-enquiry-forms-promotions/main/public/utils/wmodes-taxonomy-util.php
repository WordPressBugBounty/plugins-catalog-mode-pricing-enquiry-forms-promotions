<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}


if ( !class_exists( 'WModes_Taxonomy_Util' ) ) {

    class WModes_Taxonomy_Util {

        private static $instance;
        private $attribute_taxonomy_names;
        private $taxonomies;
        private $supports;
        private $cached_supports;

        public static function get_instance(): self {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function __construct() {

            $this->cached_supports = array();

            add_action( 'registered_taxonomy', array( $this, 'cache_registered_taxonomy' ), 9999, 3 );
        }

        public function get_taxonomies() {

            if ( !is_null( $this->taxonomies ) ) {

                return $this->taxonomies;
            }

            $this->taxonomies = array(
                'product_cat' => array(
                    'terms_key' => 'category_ids',
                    'supports' => $this->get_supports( 'product_cat' ),
                ),
                'product_tag' => array(
                    'terms_key' => 'tag_ids',
                    'supports' => $this->get_supports( 'product_tag' ),
                ),
            );
            
            return $this->taxonomies;
        }

        public function cache_registered_taxonomy( $taxonomy, $object_type, $data ) {

            $hierarchical = null;

            if ( isset( $data[ 'hierarchical' ] ) ) {

                $hierarchical = $data[ 'hierarchical' ];
            }

            $support_data = $this->process_support_data( $taxonomy, $object_type, $hierarchical );

            if ( !$support_data ) {

                return;
            }

            $this->supports[ $taxonomy ] = $support_data;
        }

        private function get_supports( $taxonomy ) {

            if ( isset( $this->cached_supports[ $taxonomy ] ) ) {

                return $this->cached_supports[ $taxonomy ];
            }

            $supports = $this->load_supports();

            if ( isset( $supports[ $taxonomy ] ) ) {

                return $supports[ $taxonomy ];
            }

            return array();
        }

        private function load_supports() {

            if ( !is_null( $this->supports ) ) {

                return $this->supports;
            }

            foreach ( get_taxonomies( array(), 'objects' ) as $taxonomy => $data ) {

                $object_type = null;
                $hierarchical = null;

                if ( !is_null( $data->object_type ) ) {

                    $object_type = $data->object_type;
                }

                if ( !is_null( $data->hierarchical ) ) {

                    $hierarchical = $data->hierarchical;
                }

                $support_data = $this->process_support_data( $taxonomy, $object_type, $hierarchical );

                if ( !$support_data ) {

                    continue;
                }

                $this->supports[ $taxonomy ] = $support_data;
            }

            return $this->supports;
        }

        private function process_support_data( $taxonomy, $object_type, $hierarchical ) {

            if ( in_array( $taxonomy, $this->get_exlc_taxonomy_ids() ) ) {

                return false;
            }

            if ( !is_array( $object_type ) ) {

                return false;
            }

            if ( !in_array( 'product', $object_type ) ) {

                return false;
            }

            $support_data = array();

            if ( in_array( 'product_variation', $object_type ) ) {

                $support_data[] = 'variations';
            }

            if ( $hierarchical ) {

                $support_data[] = 'ancestors';
            }

            return $support_data;
        }

        private function get_exlc_taxonomy_ids() {

            $exlc_taxonomy_ids = $this->get_attribute_taxonomy_names();
            $exlc_taxonomy_ids[] = 'product_type';
            $exlc_taxonomy_ids[] = 'product_visibility';
            $exlc_taxonomy_ids[] = 'product_shipping_class';

            return $exlc_taxonomy_ids;
        }

        private function get_attribute_taxonomy_names() {

            if ( !is_null( $this->attribute_taxonomy_names ) ) {

                return $this->attribute_taxonomy_names;
            }

            $this->attribute_taxonomy_names = wc_get_attribute_taxonomy_names();

            return $this->attribute_taxonomy_names;
        }

    }

}