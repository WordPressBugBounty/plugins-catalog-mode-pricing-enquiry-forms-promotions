<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'Reon' ) ) {
    return;
}

if ( !class_exists( 'WModes_Admin_Settings_Styles_TextBlock_Settings' ) ) {

    class WModes_Admin_Settings_Styles_TextBlock_Settings {

        public static function init() {

            add_filter( 'wmodes-admin/get-settings-styles-section-panels', array( new self(), 'get_panel' ), 110 );

            add_filter( 'reon/get-repeater-field-wmodes_textblocks-templates', array( new self(), 'get_templates' ), 10, 2 );

            add_filter( 'roen/get-repeater-template-wmodes_textblocks-ui_default-fields', array( new self(), 'get_template_fields' ), 10, 2 );
            add_filter( 'roen/get-repeater-template-wmodes_textblocks-ui_option-fields', array( new self(), 'get_template_fields' ), 10, 2 );
        }

        public static function get_panel( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'panel',
                'last' => true,
                'white_panel' => false,
                'panel_size' => 'smaller',
                'width' => '100%',
                'field_css_class' => array( 'wmodes_setting_panel' ),
                'merge_fields' => false,
                'fields' => self::get_fields( array() ),
            );

            return $in_fields;
        }

        public static function get_templates( $in_templates, $repeater_args ) {

            $in_templates[] = array(
                'id' => 'ui_default',
                'head' => array(
                    'title' => '',
                    'defaut_title' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'title_field' => 'admin_note',
                ),
                'empy_button' => true,
            );

            $in_templates[] = array(
                'id' => 'ui_option',
                'head' => array(
                    'title' => '',
                    'defaut_title' => esc_html__( 'Text Block', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'title_field' => 'admin_note',
                ),
            );

            return $in_templates;
        }

        public static function get_template_fields( $in_fields, $repeater_args ) {

            $in_fields[] = array(
                'id' => 'ui_id',
                'type' => 'autoid',
                'autoid' => 'wmodes_ui',
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 1,
                'full_width' => true,
                'merge_fields' => false,
                'fields' => self::admin_note_fields( array() ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 5,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( 'Content Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to control the text block content', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'wmodes_subtitles' ),
                'fields' => self::content_fields( array() ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 3,
                'full_width' => true,
                'center_head' => true,
                'merge_fields' => false,
                'title' => esc_html__( 'Container Settings', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to control the text block container', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'field_css_class' => array( 'wmodes_subtitles' ),
                'fields' => self::container_fields( array() ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 2,
                'merge_fields' => false,
                'fields' => self::container_two_fields( array() ),
            );

            $in_fields[] = array(
                'id' => 'any_ids',
                'type' => 'columns-field',
                'columns' => 4,
                'merge_fields' => false,
                'fields' => self::container_three_fields( array() ),
            );

            return $in_fields;
        }

        private static function get_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'any_id',
                'type' => 'paneltitle',
                'full_width' => true,
                'center_head' => true,
                'title' => esc_html__( 'Text Block Designs', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'desc' => esc_html__( 'Use these settings to create and manage text block designs', 'catalog-mode-pricing-enquiry-forms-promotions' ),
            );

            $in_fields[] = array(
                'id' => 'ui_textblocks',
                'filter_id' => 'wmodes_textblocks',
                'type' => 'repeater',
                'white_repeater' => true,
                'repeater_size' => 'smaller',
                'max_sections' => (defined( 'WMODES_PREMIUM_ADDON' )) ? 9999 : 2,
                'max_sections_msg' => esc_html__( 'Please upgrade to premium version in order to add more design options', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'accordions' => true,
                'buttons_sep' => false,
                'delete_button' => true,
                'clone_button' => false,
                'width' => '100%',
                'default' => self::get_default_ui(),
                'static_template' => 'ui_default',
                'section_type_id' => 'option_type',
                'auto_expand' => array(
                    'new_section' => true,
                    'cloned_section' => false,
                ),
                'sortable' => array(
                    'enabled' => false,
                ),
                'template_adder' => array(
                    'position' => 'right',
                    'show_list' => false,
                    'button_text' => esc_html__( 'New Design', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
            );

            return $in_fields;
        }

        private static function admin_note_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'admin_note',
                'type' => 'textbox',
                'tooltip' => esc_html__( 'Adds a private note for reference purposes', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'column_size' => 1,
                'column_title' => esc_html__( 'Admin Note', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'placeholder' => esc_html__( 'Type here...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function content_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'text_color',
                'type' => 'colorpicker',
                'column_width' => '165px',
                'column_title' => esc_html__( 'Text Color', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the header's text color of the content", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => WModes_Admin_Utils::get_theme_value( 'color_1' ),
                'buton_text' => esc_html__( 'Pick color', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'font_size',
                'type' => 'group-field',
                'column_width' => '165px',
                'merge_fields' => true,
                'fluid-group' => true,
                'column_title' => esc_html__( 'Font Size', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls the font size of the content', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_size_fields( array( 'default_size' => 12, 'default_unit' => 'px' ) ),
            );

            $in_fields[] = array(
                'id' => 'line_height',
                'type' => 'group-field',
                'column_width' => '165px',
                'merge_fields' => true,
                'fluid-group' => true,
                'column_title' => esc_html__( 'Line Height', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls the line height of the content', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_size_fields( array( 'default_size' => 26, 'default_unit' => 'px' ) ),
            );

            $in_fields[] = array(
                'id' => 'font_weight',
                'type' => 'select2',
                'column_width' => '150px',
                'column_title' => esc_html__( 'Font Weight', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the title's font weight of the content", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'options' => array(
                    '' => esc_html__( 'Defualt', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '100' => esc_html__( '100', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '200' => esc_html__( '200', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '300' => esc_html__( '300', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '400' => esc_html__( '400', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '500' => esc_html__( '500', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '600' => esc_html__( '600', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '700' => esc_html__( '700', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '800' => esc_html__( '800', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    '900' => esc_html__( '900', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'lighter' => esc_html__( 'lighter', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'normal' => esc_html__( 'Normal', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'bold' => esc_html__( 'Bold', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'bolder' => esc_html__( 'Bolder', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'font_family',
                'type' => 'textbox',
                'column_no_size' => true,
                'column_title' => esc_html__( 'Font Family', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the title's font family of the content", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => '',
                'placeholder' => esc_html__( 'Font family...', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
            );

            return $in_fields;
        }

        private static function container_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'justify_contents',
                'type' => 'select2',
                'column_no_size' => true,
                'column_title' => esc_html__( 'Justify Content', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Determines the contents alignment of the text block containter', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'center',
                'options' => array(
                    'left' => esc_html__( 'Justify left', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'center' => esc_html__( 'Justify center', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'right' => esc_html__( 'Justify right', 'catalog-mode-pricing-enquiry-forms-promotions' )
                ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'bg_color',
                'type' => 'colorpicker',
                'column_width' => '200px',
                'column_title' => esc_html__( 'Background Color', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the header's background color of the container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => WModes_Admin_Utils::get_theme_value( 'color_4' ),
                'buton_text' => esc_html__( 'Pick color', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
            );

            $in_fields[] = array(
                'id' => 'width',
                'type' => 'group-field',
                'column_width' => '200px',
                'merge_fields' => true,
                'fluid-group' => true,
                'column_title' => esc_html__( 'Width', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( 'Controls the width of the container', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_size_fields( array( 'default_size' => '', 'placeholder' => 'auto', 'default_unit' => 'px' ) ),
            );

            return $in_fields;
        }

        private static function container_two_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'padding',
                'type' => 'group-field',
                'column_size' => 1,
                'merge_fields' => true,
                'fluid-group' => true,
                'column_title' => esc_html__( 'Padding', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'column_classes' => array( 'wmodes_box_hint' ),
                'tooltip' => esc_html__( "Determines the padding of the text block's container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_boundary_sizes_fields( array( 'default_size' => array( 'top' => 5, 'right' => 8, 'bottom' => 5, 'left' => 8 ), 'placeholder' => '', 'default_unit' => 'px' ) ),
            );

            $in_fields[] = array(
                'id' => 'margin',
                'type' => 'group-field',
                'column_size' => 1,
                'merge_fields' => true,
                'fluid-group' => true,
                'column_title' => esc_html__( 'Margin', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'column_classes' => array( 'wmodes_box_hint' ),
                'tooltip' => esc_html__( "Determines the margins of the text block's container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_boundary_sizes_fields( array( 'default_size' => array( 'top' => '', 'right' => '', 'bottom' => 15, 'left' => '' ), 'placeholder' => '', 'default_unit' => 'px' ) ),
            );

            return $in_fields;
        }

        private static function container_three_fields( $in_fields ) {

            $in_fields[] = array(
                'id' => 'border_radius',
                'type' => 'group-field',
                'column_width' => '170px',
                'merge_fields' => true,
                'fluid-group' => true,
                'column_title' => esc_html__( 'Border Radius', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Determines the border radius of the text block's container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_size_fields( array( 'default_size' => '0', 'default_unit' => 'px' ) ),
            );

            $in_fields[] = array(
                'id' => 'border_style',
                'type' => 'select2',
                'column_no_size' => true,
                'column_title' => esc_html__( 'Border Style', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the border style of the text block's container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => 'none',
                'options' => array(
                    'none' => esc_html__( 'None', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'solid' => esc_html__( 'Solid', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'dotted' => esc_html__( 'Dotted', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                    'dashed' => esc_html__( 'Dashed', 'catalog-mode-pricing-enquiry-forms-promotions' )
                ),
                'width' => '100%',
                'column_attributes' => array(
                    'style' => 'min-width:170px;'
                ),
                'fold_id' => 'text_block_border_style',
            );

            $in_fields[] = array(
                'id' => 'border_color',
                'type' => 'colorpicker',
                'column_no_size' => true,
                'column_title' => esc_html__( 'Border Color', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'tooltip' => esc_html__( "Controls the border color of the text block's container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'default' => WModes_Admin_Utils::get_theme_value( 'color_1' ),
                'buton_text' => esc_html__( 'Pick color', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'column_attributes' => array(
                    'style' => 'min-width:170px;'
                ),
                'fold' => array(
                    'target' => 'text_block_border_style',
                    'attribute' => 'value',
                    'value' => array( 'none' ),
                    'oparator' => 'neq',
                    'clear' => false,
                ),
            );

            $in_fields[] = array(
                'id' => 'border_width',
                'type' => 'group-field',
                'merge_fields' => true,
                'fluid-group' => true,
                'column_no_size' => true,
                'column_title' => esc_html__( 'Border Width', 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'column_classes' => array( 'wmodes_box_hint' ),
                'tooltip' => esc_html__( "Controls the border width of the text block's container", 'catalog-mode-pricing-enquiry-forms-promotions' ),
                'width' => '100%',
                'fields' => WModes_Admin_Utils::get_boundary_sizes_fields( array( 'default_size' => 1, 'default_unit' => 'px' ) ),
                'fold' => array(
                    'target' => 'text_block_border_style',
                    'attribute' => 'value',
                    'value' => array( 'none' ),
                    'oparator' => 'neq',
                    'clear' => false,
                ),
            );

            return $in_fields;
        }

        private static function get_default_ui() {

            return array(
                array(
                    'calc_option_type' => 'ui_default',
                    'ui_id' => '2234343',
                ),
            );
        }

    }

    WModes_Admin_Settings_Styles_TextBlock_Settings::init();
}