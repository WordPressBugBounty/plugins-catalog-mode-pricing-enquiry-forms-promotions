<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {

    return;
}

if ( !class_exists( 'WModes_Admin_Locale' ) ) {

    class WModes_Admin_Locale {

        private static $instance;
        private $prev_translation_ids_key = 'wmodes_locale_ids';
        private $translator_obj;

        public static function get_instance(): self {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function process_options( $options ) {

            $translator = $this->get_translator();

            if ( !$translator ) {

                return $options;
            }

            $strings = $this->get_strings( $options );

            if ( !$strings ) {

                return $options;
            }

            $this->unregister_prev_strings( $strings, $translator );

            $this->register_strings( $strings, $translator );

            return $options;
        }

        private function register_strings( $strings, $translator ) {

            if ( !method_exists( $translator, 'register_string' ) ) {

                return;
            }

            foreach ( $strings as $translation_id => $value ) {

                $translator->register_string( $value, $translation_id );
            }
        }

        private function unregister_prev_strings( $strings, $translator ) {

            if ( !method_exists( $translator, 'unregister_string' ) ) {

                return;
            }

            $new_translation_ids = array_keys( $strings );

            $prev_translation_ids = $this->get_prev_translation_id_ids();


            foreach ( $prev_translation_ids as $translation_id ) {

                if ( in_array( $translation_id, $new_translation_ids ) ) {

                    continue;
                }

                $translator->unregister_string( $translation_id );
            }

            $this->save_new_translation_id_ids( $new_translation_ids );
        }

        private function get_strings( $options ) {

            //TODO: Remove this block later
            if ( !defined( 'WMODES_DEV_LOCALE' ) ) {

                return false;
            }
            //TODO: End of block

            
            $strings = apply_filters( 'wmodes/get-locale-strings', array(), $options );

            if ( !is_array( $strings ) ) {

                return false;
            }

            if ( !count( $strings ) ) {

                return false;
            }

            return $strings;
        }

        private function get_prev_translation_id_ids() {

            return get_option( $this->prev_translation_ids_key, array() );
        }

        private function save_new_translation_id_ids( $new_translation_ids ) {

            if ( !count( $new_translation_ids ) ) {

                delete_option( $this->prev_translation_ids_key );
            } else {

                update_option( $this->prev_translation_ids_key, $new_translation_ids, false );
            }
        }

        private function get_translator() {

            if ( !is_null( $this->translator_obj ) ) {

                return $this->translator_obj;
            }

            $this->translator_obj = false;

            $translators = $this->register_translators();

            if ( !is_array( $translators ) ) {

                return $this->translator_obj;
            }

            foreach ( $translators as $translator ) {

                if ( !class_exists( $translator ) ) {

                    continue;
                }

                if ( method_exists( $translator, 'get_instance' ) ) {

                    $this->translator_obj = $translator::get_instance();
                } else {

                    $this->translator_obj = new $translator();
                }

                return $this->translator_obj;
            }

            return $this->translator_obj;
        }

        private function register_translators() {

            $translators = array();

            //TODO: Remove this block later
            if ( !defined( 'WMODES_DEV_LOCALE' ) ) {

                return $translators;
            }
            //TODO: End of block

            if ( class_exists( 'WModes_Polylang' ) ) {

                $translators[ 'polylang' ] = 'WModes_Polylang';
            }

            if ( class_exists( 'WModes_WPML' ) ) {

                $translators[ 'wpml' ] = 'WModes_WPML';
            }

            return apply_filters( 'wmodes/register-locale-translators', $translators );
        }

    }

}