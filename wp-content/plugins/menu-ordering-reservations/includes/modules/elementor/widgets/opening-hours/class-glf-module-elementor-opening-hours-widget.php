<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'Glf_Module_Elementor_Opening_Hours_Widget' ) ) {

    /**
     * GloriaFood Elementor Widget implementation
     *
     * @since 1.5.0
     */
    class Glf_Module_Elementor_Opening_Hours_Widget extends \Elementor\Widget_Base {

        public function __construct( $data = [], $args = null ) {
            parent::__construct( $data, $args );

            add_action( 'init', array( $this, 'menu_ordering_reservations_set_script_translations' ) );
        }

        /**
         * Set widget name
         *
         * Used by elementor to identify the widget
         */
        public function get_name() {
            return 'glf_elementor_opening_hours';
        }

        /**
         * Set widget title
         *
         * Visual widget label on the builder
         */
        public function get_title() {
            return __( 'Opening Hours', 'menu-ordering-reservations' );
        }

        /**
         * Set widget icon
         *
         * Visual widget icon css class
         */
        public function get_icon() {
            return 'glf-elementor-opening-hours-widget-icon';
        }

        /**
         * Set widget keywords
         *
         * Widget keywords used for searching
         */
        public function get_keywords() {
            return [ 'restaurant', 'opening hours', 'opening', 'hours', 'gloria', 'food' ];
        }

        /**
         * Set widget category
         *
         * We are creating our own custom category
         *
         * Default values: 'base' , 'general'
         */
        public function get_categories() {
            return [ 'gloria-food' ];
        }

        /**
         * Register Food Menu widget controls.
         *
         * Adds a select field for location and an input field for the custom css class.
         *
         * @since 1.0.0
         * @access protected
         */
        protected function _register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => __( 'Settings', 'menu-ordering-reservations' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );

            $select = Glf_Utils::glf_get_restaurants_dropdown_elementor();
            $this->add_control(
                'glf_ruid',
                [
                    'label' => __( 'Select restaurant', 'menu-ordering-reservations' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => $select[ 'default' ],
                    'options' => $select[ 'options' ],
                ]
            );

            $this->add_control(
                'widget_title',
                [
                    'label' => esc_html__( 'Title', 'plugin-name' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( 'Default title', 'plugin-name' ),
                    'placeholder' => esc_html__( 'Type your title here', 'plugin-name' ),
                ]
            );

            $this->end_controls_section();

        }

        /**
         * Render Food Menu output on the frontend.
         *
         * Written in PHP and used to generate the final HTML.
         *
         * @since 1.0.0
         * @access protected
         */
        protected function render() {

            $settings = $this->get_settings_for_display();
            $atts = array( 'ruid' => $settings[ 'glf_ruid' ] );

            if ( !empty( $settings[ 'glf_class' ] ) ) {
                $atts[ 'class' ] = $settings[ 'glf_class' ];
            }
            $widgetRawData = $this->get_raw_data();
            Glf_Utils::glf_prepare_tracking_data( 'opening-hours', $atts, 'elementor', 'opening_hours_widget', $widgetRawData['id'] );
            $atts[ 'elementor' ] = '';
            echo Glf_Module_Shortcodes::add_opening_hours( $atts );

        }

        protected function content_template() {
            ?>
            <h2>{{{settings.widget_title}}}</h2>
            <?php
        }


        public function menu_ordering_reservations_set_script_translations() {
            wp_set_script_translations( 'menu-ordering-editor', 'menu-ordering-reservations', GLF_PLUGIN_DIR . 'languages' );
        }
    }
}
