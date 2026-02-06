<?php

if ( !defined( 'ABSPATH' ) ) {

    exit;
}


if ( !class_exists( 'WModes_Terms_Validation_Util' ) ) {

    class WModes_Terms_Validation_Util {

        private static $instance;
        private $term_ancestors;

        public static function get_instance(): self {

            if ( !self::$instance ) {

                self::$instance = new self();
            }

            return self::$instance;
        }

        public function __construct() {

            $this->term_ancestors = array();
        }

        public function validate_value_list( $value, $rule_list, $validate_type, $taxonomy, $use_ancestors ) {

            $found = $this->term_in_array( $value, $rule_list, $taxonomy, $use_ancestors );

            $is_equals = ('in_list' == $validate_type );

            return ($found == $is_equals);
        }

        public function validate_list_list( $list, $rule_list, $validate_type, $taxonomy, $use_ancestors ) {

            if ( $validate_type == 'in_list' || $validate_type == 'none' ) {

                return $this->validate_list_in_list( $list, $rule_list, $validate_type, $taxonomy, $use_ancestors );
            }

            if ( $validate_type == 'in_all_list' ) {

                return $this->validate_list_all_in_list( $list, $rule_list, $taxonomy, $use_ancestors );
            }

            if ( $validate_type == 'in_list_only' ) {

                return $this->validate_list_only_in_list( $list, $rule_list, $taxonomy, $use_ancestors );
            }

            if ( $validate_type == 'in_all_list_only' ) {

                $all_list = $this->validate_list_all_in_list( $list, $rule_list, $taxonomy, $use_ancestors );

                $only_list = $this->validate_list_only_in_list( $list, $rule_list, $taxonomy, $use_ancestors );

                return ($all_list == true && $only_list == true);
            }

            return false;
        }

        private function validate_list_in_list( $list, $rule_list, $validate_type, $taxonomy, $use_ancestors ) {

            $found = false;

            $is_equals = ('in_list' == $validate_type );

            foreach ( $list as $lst ) {

                if ( true == $found ) {

                    break;
                }

                if ( $this->validate_value_list( $lst, $rule_list, 'in_list', $taxonomy, $use_ancestors ) ) {

                    $found = true;
                }
            }

            return ($found == $is_equals);
        }

        private function validate_list_all_in_list( $list, $rule_list, $taxonomy, $use_ancestors ) {

            $found_count = 0;

            $rule_list_count = count( $rule_list );

            foreach ( $list as $lst ) {

                if ( $this->validate_value_list( $lst, $rule_list, 'in_list', $taxonomy, $use_ancestors ) ) {

                    $found_count++;
                }
            }

            return ($found_count == $rule_list_count);
        }

        private function validate_list_only_in_list( $list, $rule_list, $taxonomy, $use_ancestors ) {

            $found_count = 0;

            $list_count = count( $list );

            foreach ( $list as $lst ) {

                if ( $this->validate_value_list( $lst, $rule_list, 'in_list', $taxonomy, $use_ancestors ) ) {

                    $found_count++;
                }
            }

            return ($found_count == $list_count);
        }

        private function term_in_array( $needle, $haystack, $taxonomy, $use_ancestors ) {

            if ( !$use_ancestors ) {

                return in_array( $needle, $haystack );
            }


            if ( in_array( $needle, $haystack ) ) {

                return true;
            }

            foreach ( $this->get_term_ancestors( $needle, $taxonomy ) as $term_id ) {

                if ( in_array( $term_id, $haystack ) ) {

                    return true;
                }
            }

            return false;
        }

        private function get_term_ancestors( $term_id, $taxonomy ) {

            if ( isset( $this->term_ancestors[ $taxonomy ][ $term_id ] ) ) {

                return $this->term_ancestors[ $taxonomy ][ $term_id ];
            }

            if ( !isset( $this->term_ancestors[ $taxonomy ] ) ) {

                $this->term_ancestors[ $taxonomy ] = array();
            }

            $ancestors = get_ancestors( $term_id, $taxonomy );

            if ( !is_array( $ancestors ) ) {

                $ancestors = array();
            }

            $ancestors_count = count( $ancestors );

            $this->term_ancestors[ $taxonomy ][ $term_id ] = $ancestors;

            if ( !$ancestors_count ) {

                return $this->term_ancestors[ $taxonomy ][ $term_id ];
            }

            for ( $i = 0; $i < $ancestors_count; $i++ ) {

                $ancestor = $ancestors[ $i ];

                $this->term_ancestors[ $taxonomy ][ $ancestor ] = $this->get_process_term_ancestors( ($i + 1 ), $ancestors, $ancestors_count );
            }

            return $this->term_ancestors[ $taxonomy ][ $term_id ];
        }

        private function get_process_term_ancestors( $next_i, $ancestors, $ancestors_count ) {

            $next_ancestors = array();

            for ( $i = $next_i; $i < $ancestors_count; $i++ ) {

                $next_ancestors[] = $ancestors[ $i ];
            }

            return $next_ancestors;
        }

    }

}