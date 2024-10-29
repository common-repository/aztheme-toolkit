<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Producta_Posts_Latest extends Widget_Base {

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
        return 'producta-latest-posts';
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
    public function get_title(){
        return __( 'Producta Latest Posts', 'aztheme-toolkit' );
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
                'label' => __( 'Latest Posts', 'aztheme-toolkit' ),
            ]
        );
        $options = $this->get_post_categories();
        $this->add_control(
            'category_post',
            [
                'label' => __( 'Select Category', 'aztheme-toolkit' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $options,
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
                'default' => 6,
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
        $cat_posts  = $settings['category_post'];
		$number_posts = $settings['number_posts'];
        
        $query = array(
            'cat'                   => $cat_posts,
            'showposts'             => $number_posts,
            'nopaging'              => 0,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'paged'                 => get_query_var('page')
        );

        $loop = query_posts($query);
        if ( have_posts() ) :
        ?>
            
        <div class="producta-posts-latest">
        	<div class="row g-xl-6">
            <?php
            $i = 0;
            while (have_posts() ) { 
                the_post();
            ?>
            <article <?php post_class(' item-post col-md-4'); ?>>
                <div class="post-inner">
                    <?php get_template_part('template-parts/post', 'format'); ?>
                    <div class="post-info">
                        <?php get_template_part('template-parts/post', 'meta'); ?>
                        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </div>
                </div>
            </article>          
            <?php }; ?>
           	</div>
        </div>
        <?php
        endif;
        wp_reset_query();
    }

    /**List Cats **/
    function get_post_categories()
    {
        $options = array();
        $options[''] = 'All Categories';
        $categories = get_categories( 'hide_empty=0&depth=1&type=post' );
        foreach( $categories as $category ) {
            $options[$category->term_id] = $category->cat_name;
        }
        return $options;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Producta_Posts_Latest() );