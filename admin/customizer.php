<?php
if ( ! function_exists( 'aztheme_toolkit_theme_customizer' ) ) {
    /**
     * Add Social Media Links to Customizer
     */
    function aztheme_toolkit_theme_customizer( $wp_customize ) {
        /**
         * Social Media settings
         */
        $wp_customize->add_section( 'aztheme_section_social_media_links', array( 'title' => __( 'Social Media Links', 'aztheme-toolkit' ) ) );
        $wp_customize->add_setting( 'aztheme_facebook_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_twitter_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_instagram_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_pinterest_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_youtube_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_tumblr_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_bloglovin_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_dribbble_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_soundcloud_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_vimeo_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_setting( 'aztheme_linkedin_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
    
    	$wp_customize->add_control( 'aztheme_facebook_url', array(
    	   'label'     => __( 'Facebook URL', 'aztheme-toolkit' ),
    	   'section'   => 'aztheme_section_social_media_links'
    	));

    	$wp_customize->add_control( 'aztheme_twitter_url', array(
			'label'      => __( 'Twitter URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
    	));

    	$wp_customize->add_control( 'aztheme_instagram_url', array(
			'label'      => __( 'Instagram URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
		));

    	$wp_customize->add_control( 'aztheme_pinterest_url', array(
			'label'      => __( 'Pinterest URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
    	));

    	$wp_customize->add_control( 'aztheme_youtube_url', array(
			'label'      => __( 'Youtube URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
    	));

    	$wp_customize->add_control( 'aztheme_tumblr_url', array(
			'label'      => __( 'Tumblr URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
    	));

    	$wp_customize->add_control( 'aztheme_bloglovin_url', array(
			'label'      => __( 'Bloglovin URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
    	));

    	$wp_customize->add_control( 'aztheme_dribbble_url', array(
			'label'      => __( 'Dribbble URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
		));

    	$wp_customize->add_control( 'aztheme_soundcloud_url', array(
			'label'      => __( 'SoundCloud URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
		));

    	$wp_customize->add_control( 'aztheme_vimeo_url', array(
				'label'      => __( 'Vimeo URL', 'aztheme-toolkit' ),
				'section'    => 'aztheme_section_social_media_links'
		));

    	$wp_customize->add_control( 'aztheme_linkedin_url', array(
			'label'      => __( 'LinkedIn URL', 'aztheme-toolkit' ),
			'section'    => 'aztheme_section_social_media_links'
    	));
    }
    add_action( 'customize_register', 'aztheme_toolkit_theme_customizer' );
}
