<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WModes_Pipeline_Variation_Prices' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_Pipeline_Variation_Prices {
        
        private $currency;

        public function __construct() {

            add_filter( 'woocommerce_variation_prices_sale_price', array( $this, 'get_variation_sale_price' ), 99999, 3 );
            add_filter( 'woocommerce_variation_prices_price', array( $this, 'get_variation_price' ), 99999, 3 );

            add_filter( 'woocommerce_get_variation_prices_hash', array( $this, 'get_variation_prices_hash' ), 10, 3 );
        }

        public function get_variation_sale_price( $price, $variation, $product ) {

            $pipeline_prices = WModes_Pipeline_Prices::get_instance();

            $pipeline_data = $pipeline_prices->get_calculated_prices( $product, $variation );

            if ( isset( $pipeline_data[ 'sale_price' ] ) ) {

                return apply_filters( 'wmodes/get-sale-price', $this->convert_amount( $pipeline_data[ 'sale_price' ], 'pipeline-sale-price' ), $product, $variation );
            }

            return $price;
        }

        public function get_variation_price( $price, $variation, $product ) {

            $pipeline_prices = WModes_Pipeline_Prices::get_instance();

            $pipeline_data = $pipeline_prices->get_calculated_prices( $product, $variation );

            if ( isset( $pipeline_data[ 'price' ] ) ) {

                return apply_filters( 'wmodes/get-price', $this->convert_amount( $pipeline_data[ 'price' ], 'pipeline-price' ), $product, $variation );
            }

            return $price;
        }

        public function get_variation_prices_hash( $price_hash, $product, $for_display ) {

            $pipeline_prices = WModes_Pipeline_Prices::get_instance();

            $wmodes_hash = $pipeline_prices->get_prices_hash( $product );

            $price_hash[ 'wmodes' ] = md5( wp_json_encode( $wmodes_hash ) );

            return $price_hash;
        }
        
        private function convert_amount( $amount, $amount_id ) {

            if ( is_null( $this->currency ) ) {

                $this->currency = WModes_Currency::get_instance();
            }

            return $this->currency->convert_amount( $amount, $amount_id );
        }

    }

    new WModes_Pipeline_Variation_Prices();
}