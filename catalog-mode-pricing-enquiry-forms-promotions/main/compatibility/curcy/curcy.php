<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}

if ( !class_exists( 'WModes_CURCY' ) && function_exists( 'wmc_get_price' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_CURCY {

        private static $instance;

        public static function get_instance(): self {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function convert_amount( $amount ) {

            if ( function_exists( 'wmc_get_price' ) ) {

                return wmc_get_price( $amount );
            }

            return $amount;
        }

        public function revert_amount( $amount ) {
           
            if ( function_exists( 'wmc_revert_price' ) ) {

                return wmc_revert_price( $amount );
            }

            return $amount;
        }

        public function can_convert_amount( $amount_id ) {

            return true;
        }

        public function can_revert_amount( $amount_id ) {

            return true;
        }

    }

}