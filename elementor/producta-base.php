<?php
class AZTheme_Toolkit_Elementor_Setup
{
	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Rebecca_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}
	
    public function __construct()
    {
		/**
		 * Detect plugin. For use on Front End only.
		 */
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		// check for plugin using plugin name
		if ( is_plugin_active( 'elementor/elementor.php' ) ) {
			add_action('elementor/init', array($this, 'initiate_elementor_addons'));
        	add_action('elementor/widgets/widgets_registered', array($this, 'addons_widget_register'));
		}
    }

    public function addons_widget_register()
    {
        aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/elementor/element-widget/producta-posts-layout.php' );
        aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/elementor/element-widget/producta-list-icon.php' );
        aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/elementor/element-widget/producta-service.php' );

        if ( post_type_exists('portfolio') ) {
			aztheme_toolkit_require_file( AZTHEME_TOOLKIT_DIR . '/elementor/element-widget/producta-portfolio.php' );
		}
    }

    //Create new section on elementor
    public function initiate_elementor_addons()
    {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'producta-section',
            array(
                'title' => __('Producta Extentions', 'aztheme-toolkit')
            )
        );
    }
}

AZTheme_Toolkit_Elementor_Setup::instance();
