<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WModes_YayCurrency' ) && class_exists( '\Yay_Currency\Helpers\YayCurrencyHelper' ) && !defined( 'WMODES_PREMIUM_ADDON' ) ) {

    class WModes_YayCurrency {

        private static $instance;
        private $current_currency;
        private $is_internal;

        public static function get_instance(): self {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function __construct() {

            add_filter( 'yay_currency_should_format_product_price', array( $this, 'should_format_currency' ), 99999, 3 );
        }

        public function should_format_currency( $shoul_format, $price, $apply_currency ) {

            if ( $this->is_internal ) {

                return false;
            }

            return $shoul_format;
        }

        public function convert_amount( $amount ) {

            $this->is_internal = true;

            if ( class_exists( '\Yay_Currency\Helpers\YayCurrencyHelper' ) ) {

                $amount = \Yay_Currency\Helpers\YayCurrencyHelper::calculate_price_by_currency( $amount, false, $this->get_current_currency() );
            }

            $this->is_internal = false;

            return $amount;
        }

        public function revert_amount( $amount ) {

            $this->is_internal = true;

            if ( class_exists( '\Yay_Currency\Helpers\YayCurrencyHelper' ) ) {

                $amount = \Yay_Currency\Helpers\YayCurrencyHelper::reverse_calculate_price_by_currency( $amount );
            }

            $this->is_internal = false;

            return $amount;
        }

        public function can_convert_amount( $amount_id ) {

            return true;
        }

        public function can_revert_amount( $amount_id ) {

            return true;
        }

        private function get_current_currency() {

            if ( !is_null( $this->current_currency ) ) {

                return $this->current_currency;
            }

            $this->current_currency = \Yay_Currency\Helpers\YayCurrencyHelper::detect_current_currency();

            return $this->current_currency;
        }


    }

}