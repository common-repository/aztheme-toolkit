<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Producta_Service extends Widget_Base {

    /**

     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'producta_service';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Producta Service', 'aztheme-toolkit' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-icon-box';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'producta-section' ];
    }


    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
        'addon_text_display',
            [
                'label' => __( 'Producta Service', 'aztheme-toolkit' ),
            ]
        );
        $this->add_control(
            'service_icon',
            [
                'label' => esc_html__( 'Icon', 'aztheme-toolkit' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'fa4compatibility' => 'icon',
            ]
        );
        $this->add_control(
            'service_title',
            [
                'label' => __( 'Title', 'aztheme-toolkit' ),
                'type' => \Elementor\Controls_Manager::TEXT,                
                'placeholder' => __( 'Type your title here', 'aztheme-toolkit' ),
            ]
        );
        $this->add_control(
            'service_desc',
            [
                'label' => esc_html__( 'Description', 'aztheme-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__( 'Text description', 'aztheme-toolkit' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );
        

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_list',
            [
                'label' => esc_html__( 'Service Style', 'aztheme-toolkit' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .service-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_color_background',
            [
                'label' => esc_html__( 'Background Icon', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text Color', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-desc' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'border_color',
            [
                'label' => esc_html__( 'Border Color', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .producta-service' => 'border-color: {{VALUE}};',
                ],
            ]
        );
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="producta-service">
            <div class="service-icon">
                <?php
                    \Elementor\Icons_Manager::render_icon( $settings['service_icon'], [ 'aria-hidden' => 'true' ] );
                ?>
            </div>
            <div class="service-info">
                <h4 class="service-title"><?php echo esc_html( $settings['service_title'] ); ?></h4>
                <div class="service-desc"><?php echo esc_html( $settings['service_desc'] ); ?></div>
            </div>
        </div>
    <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Producta_Service() );