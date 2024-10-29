<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Producta_Portfolio extends Widget_Base {
    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name(){
        return 'producta-portfolio';
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
        return __( 'Producta Portfolio', 'aztheme-toolkit' );
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
        return 'eicon-posts-grid';
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
                'label' => __( 'Producta Portfolio', 'aztheme-toolkit' ),
            ]
        );
        $categories = $this->get_portfolio_categories();
        $this->add_control(
            'cat_portfolio',
            [
                'label' => __( 'Select Category', 'aztheme-toolkit' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $categories,
                'default' => '',
            ]
        );
        $this->add_control(
            'number_posts',
            [
                'label' => __( 'Number Posts', 'aztheme-toolkit' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 30,
                'step' => 3,
                'default' => 3,
            ]
        );        

        $this->end_controls_section();
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
        $cat_posts  = $settings['cat_portfolio'];
		$number_posts = $settings['number_posts'];
        
        $query = array(
            'post_type'             => 'portfolio',
            'cat'                   => $cat_posts,
            'showposts'             => $number_posts,
            'nopaging'              => 0,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
        );

        $loop = query_posts($query);
        if ( have_posts() ) :
        ?>            
        <div class="producta-portfolios">
            <div class="row g-xl-6">
                <?php
                while (have_posts() ) {
                    the_post();
                ?>
                <div class="pf-item col-md-4">
                    <div class="pf-inner-item">
                        <div class="pf-image">
                            <?php $featured_image = producta_resize_image( get_post_thumbnail_id(), null, 635, 655, true ); ?>
                            <img src="<?php echo esc_url($featured_image); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <div class="pf-info">
                            <div class="pf-meta">
                                <div class="pf-auth"><?php echo esc_html__( 'by ', 'aztheme-toolkit' ) ?><span><?php the_author() ?></span></div>
                                <div class="pf-date"><?php the_date('d F Y'); ?></div>
                            </div>
                            <h4 class="pf-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                    </div>
                </div>   
                <?php }; ?>
            </div>
        </div>
        <?php
        endif;
        wp_reset_query();       
    }

    /**List Cats **/
    function get_portfolio_categories()
    {
        $categories = array();
        if ( taxonomy_exists( 'portfolio_category') ) {
            $categories[0] = 'All Categories';
            $terms = get_terms( 'portfolio_category', array( 'hide_empty' => false ) );
            if ( !empty( $terms ) ) {
                foreach ( $terms as $term ) {
                    $categories[$term->slug] = $term->name;
                }
            }
        }
        return $categories;
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Producta_Portfolio() );