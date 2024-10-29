<?php
/**
 * Plugin Name: AZTheme Toolkit
 * Plugin URI:
 * Description: AZTheme Toolkit provides you necessary widgets for better and effective blogging.
 * Version: 1.0.4
 * Author: AZ-Theme
 * Author URI: https://az-theme.net/
 * Text Domain: aztheme-toolkit
 * Domain Path: /languages
 * License: GPL v3
 * Mailchimp for WordPress
 * Copyright (C) 2021, AZ-Theme.Net, dannywpthemes@gmail.com
 */
defined( 'ABSPATH' ) or exit;
define( 'AZTHEME_TOOLKIT_DIR', __DIR__ );
define( 'AZTHEME_TOOLKIT_URL', plugin_dir_url( __FILE__ ) );

function aztheme_toolkit_portfolio_init() {
	$labels = array(
		'name'               => __( 'Portfolio Items', 'aztheme-toolkit' ),
		'singular_name'      => __( 'Portfolio', 'aztheme-toolkit' ),
		'menu_name'          => __( 'Portfolio', 'aztheme-toolkit' ),
		'name_admin_bar'     => __( 'Portfolio', 'aztheme-toolkit' ),
		'add_new'            => __( 'Add New', 'aztheme-toolkit' ),
		'add_new_item'       => __( 'Add New Project', 'aztheme-toolkit' ),
		'new_item'           => __( 'New Item', 'aztheme-toolkit' ),
		'edit_item'          => __( 'Edit Item', 'aztheme-toolkit' ),
		'view_item'          => __( 'View Item', 'aztheme-toolkit' ),
		'all_items'          => __( 'All Items', 'aztheme-toolkit' ),
		'search_items'       => __( 'Search Items', 'aztheme-toolkit' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
        'menu_icon' 		 => 'dashicons-awards',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'thumbnail', 'editor' )
	);

	register_post_type( 'portfolio', $args );

    register_taxonomy( 'portfolio_category', 'portfolio', array(
    	'hierarchical'         => true,
    	'query_var'            => 'portfolio_category',
    	'rewrite'              => false,
    	'public'               => true,
    	'show_ui'              => true,
    	'show_admin_column'    => true,
        'labels'               => array(
    		'name'            => 'Portfolio Categories',
    		'singular_name'   => 'Portfolio Category'
    	)
    ));
}

add_action( 'init', 'aztheme_toolkit_portfolio_init' );

/**
 * Check file exists and require
 */
function aztheme_toolkit_require_file( $path ) {
    if ( file_exists($path) ) {
        require $path;
    }
}

if ( ! function_exists( 'aztheme_toolkit_post_share' ) ) {
    /**
     * Post sharing
     */
    function aztheme_toolkit_post_share() {
        global $post;
        $image = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );
        $title = get_the_title($post);
        $link = get_the_permalink($post);
        ?>
        <div class="entry-share">
        	<a class="social-icon" target="_blank" href="<?php echo esc_url( "https://www.facebook.com/sharer/sharer.php?u={$link}" ); ?>"><i class="fab fa-facebook-f"></i></a>
            <a class="social-icon" target="_blank" href="<?php echo esc_url( "http://twitter.com/intent/tweet?text={$title}&url={$link}" ); ?>"><i class="fab fa-twitter"></i></a>
            <a class="social-icon" target="_blank" href="<?php echo esc_url( "https://pinterest.com/pin/create/button/?url={$link}&media={$image}&description={$desc}" ); ?>"><i class="fab fa-pinterest-p"></i></a>
        </div>
        <?php
    }
}

/**
 * Count Post Visits
 */
function aztheme_toolkit_count_post_visits()
{
    if( is_single() )
    {
        global $post;
        $views = get_post_meta( $post->ID, 'producta_post_viewed', true );
        if ( $views == '' ) {
            update_post_meta( $post->ID, 'producta_post_viewed', '1' ); 
        } else {
            $views_no = intval( $views );
            update_post_meta( $post->ID, 'producta_post_viewed', ++$views_no );
        }
    }
}

add_action( 'wp_head', 'aztheme_toolkit_count_post_visits' );

// Get Post View
function aztheme_toolkit_get_post_view()
{
    global $post;
    $view = get_post_meta( $post->ID, 'producta_post_viewed',true);
    $view = (int)$view;
    if ($view > 1 ) {
        $view = $view . ' ' . esc_html__( 'views', 'aztheme-toolkit' );
    } elseif ( $view == 1) {
         $view = $view . ' ' . esc_html__( 'views', 'aztheme-toolkit' );
    } else {
        $view = '0'. ' ' . esc_html__( 'views', 'aztheme-toolkit' );
    }

    return $view;
}


if ( ! function_exists( 'aztheme_toolkit_load_scripts' ) ) {
    /**
     * Register & Enqueue Styles / Scripts
     */
    function aztheme_toolkit_load_scripts() {
        wp_enqueue_style('aztheme-toolkit', AZTHEME_TOOLKIT_URL . '/assets/css/style.css' );
    }

    add_action( 'wp_enqueue_scripts', 'aztheme_toolkit_load_scripts' );
}

/**
 * Elementor
 */
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/elementor/producta-base.php' );

/**
 * Customizer
 */
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/admin/customizer.php' );
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/admin/categories-images/categories-images.php' );

if ( ! function_exists( 'aztheme_toolkit_category_image' ) ) {
    /**
     * Get Category Image
     * @param $cat_id
     * @return Category image URL
     */
    function aztheme_toolkit_category_image( $cat_id ) {
        if ( $cat_id ) {
            $image_id = get_term_meta ( $cat_id, 'aztheme-category-image-id', true );
            if ( $image_id ) {
                return wp_get_attachment_url($image_id);
            }
        }
    }
}
 
/**
 * Widgets
 */
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/widgets/about-me.php' );
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/widgets/categories-images.php' );
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/widgets/latest-posts.php' );
aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/widgets/social-media-links.php' );
