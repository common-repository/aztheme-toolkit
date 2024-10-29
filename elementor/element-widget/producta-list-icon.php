<?php
namespace Elementor;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Producta_List_Icon extends Widget_Base {

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
        return 'producta_list_icon';
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
        return __( 'Producta List Icon Custom', 'aztheme-toolkit' );
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
        return 'eicon-bullet-list';
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
                'label' => __( 'Producta Icon List', 'aztheme-toolkit' ),
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'text_list',
            [
                'label' => esc_html__( 'Text', 'aztheme-toolkit' ),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_html__( 'List Item', 'aztheme-toolkit' ),
                'default' => esc_html__( 'List Item', 'aztheme-toolkit' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
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
        $repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $repeater->add_control(
            'icon_color_background',
            [
                'label' => esc_html__( 'Background Icon', 'aztheme-toolkit' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .icon-list-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_list_item',
            [
                'label' => esc_html__( 'Items', 'aztheme-toolkit' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'text_list' => esc_html__( 'List Item #1', 'aztheme-toolkit' ),
                        'selected_icon' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'text_list' => esc_html__( 'List Item #2', 'aztheme-toolkit' ),
                        'selected_icon' => [
                            'value' => 'fas fa-times',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'title_field' => '{{{ text_list }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_list',
            [
                'label' => esc_html__( 'List', 'aztheme-toolkit' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__( 'Space Between', 'aztheme-toolkit' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .producta-list-icon .icon-list-item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .producta-list-icon .icon-list-item:not(:first-child)' => 'padding-top: calc({{SIZE}}{{UNIT}}/2)',
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
                    '{{WRAPPER}} .product-icon-list-text' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_SECONDARY,
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
        <ul class="producta-list-icon">
        <?php
            foreach ( $settings['icon_list_item'] as $item_list ) {
                ?>
                <li class="elementor-repeater-item-<?php echo esc_attr( $item_list['_id'] ); ?> producta-list-item">
                    <div class="icon-list-icon">
                    <?php
                        \Elementor\Icons_Manager::render_icon( $item_list['selected_icon'], [ 'aria-hidden' => 'true' ] );
                    ?>
                    </div>
                    <div class="product-icon-list-text">
                        <?php echo wp_kses_post( $item_list['text_list'] ); ?>
                    </div>
                </li><?php
            }
        ?>
        </ul>
    <?php
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Producta_List_Icon() );