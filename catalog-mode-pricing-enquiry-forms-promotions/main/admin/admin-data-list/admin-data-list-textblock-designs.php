<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Data_List_Text_Block_Designs' ) ) {

    class WModes_Admin_Data_List_Text_Block_Designs {

        public static function init() {

            add_filter( 'wmodes-admin/get-data-list-textblock_designs', array( new self(), 'get_data_list' ), 10, 2 );
        }

        public static function get_data_list( $result, $data_args ) {

            global $wmodes_settings;

            $options = array();

            if ( isset( $wmodes_settings[ 'ui_textblocks' ] ) ) {
                $options = $wmodes_settings[ 'ui_textblocks' ];
            } else {
                $options = self::get_default_options();
            }

            foreach ( $options as $option ) {
                $result[ $option[ 'ui_id' ] ] = self::get_title( $option );
            }

            return $result;
        }

        private static function get_title( $option ) {

            if ( !empty( $option[ 'admin_note' ] ) ) {
                return $option[ 'admin_note' ];
            }

            return self::get_default_title( $option[ 'ui_id' ] );
        }

        private static function get_default_title( $option_id ) {

            foreach ( self::get_default_options() as $option ) {

                if ( $option_id == $option[ 'ui_id' ] ) {
                    return $option[ 'admin_note' ];
                }
            }
            return esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' );
        }

        private static function get_default_options() {
            return array(
                array(
                    'admin_note' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'ui_id' => '2234343',
                ),
            );
        }

    }

    WModes_Admin_Data_List_Text_Block_Designs::init();
}
