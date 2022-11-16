<?php

    class Elementor_Date_Widget extends \Elementor\Widget_Base {

        public function get_name() {
            return 'date-widget';
        }

        public function get_title() {
            return esc_html__( 'Custom Date Widget', 'mts-widget' );
        }

        public function get_icon() {
            return 'eicon-code';
        }

        public function get_categories() {
            return [ 'basic' ];
        }

        public function get_keywords() {
            return [ 'hello', 'world' ];
        }

        public function get_style_depends() {

            wp_register_style( 'mts-style', plugins_url( 'style.css', __FILE__ ) );
    
            return ['mts-style'];
    
        }

        protected function register_controls() {

            $this->start_controls_section(
                'content_section',
                [
                    'label' => esc_html__( 'Content', 'textdomain' ),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]
            );
    
            $this->add_control(
                'date',
                [
                    'label' => esc_html__( 'Date', 'textdomain' ),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                    ],
                ]
            );
    
            $this->end_controls_section();
    
        }

        public function render(){
            $settings = $this->get_settings_for_display();

            $timestamp = strtotime($settings["date"]);

            $day = date("l", $timestamp);
            $date = date("M j", $timestamp);
            $year = date("Y", $timestamp);

            ?>
                <div class='mts-listing-date'>
                    <div class='mts-listing-date-top'>
                        <?php echo $day ?>
                    </div>
                    <div class='mts-listing-date-middle'>
                        <?php echo $date ?>
                    </div>
                    <div class='mts-listing-date-bottom'>
                        <?php echo $year ?>
                    </div>
                </div>
                
            <?php
        }

    }