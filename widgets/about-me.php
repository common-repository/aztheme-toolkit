<?php
if ( ! class_exists( 'AZTheme_About_Me_Widget' ) ) {
    class AZTheme_About_Me_Widget extends WP_Widget {
    	public function __construct() {
    		$widget_ops = array('classname' => 'aztheme-about-me');
    		parent::__construct('aztheme-about-me', __('AZ-Theme: About Me', 'aztheme-toolkit'), $widget_ops);
            add_action( 'admin_enqueue_scripts', [$this, 'aztheme_widget_script'] );
    	}
        
        function aztheme_widget_script() {
            wp_enqueue_media();
            wp_enqueue_script( 'aztheme-about-me-widget',  AZTHEME_TOOLKIT_URL . '/admin/js/admin-about-widget.js', false, '', true );
        }
    
    	public function widget($args, $instance) {
    		extract( $args, EXTR_SKIP );
            $title = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '', $instance, $this->id_base );
    		echo wp_kses_post($args['before_widget']);
                if ( $title ) {
                    echo wp_kses_post( $before_title . $title . $after_title );
                }
                ?>
                <div class="about-widget widget-content">
                    <?php if ( isset( $instance['image_uri'] ) && !empty( $instance['image_uri'] ) ) : ?>
                    <div class="about-img" style="background-image: url('<?php echo esc_url( $instance['image_uri'] ); ?>');"></div>
                    <?php endif; ?>
    
                    <?php if ( isset( $instance['short_desciption'] ) && !empty( $instance['short_desciption'] ) ) : ?>
                    <p><?php echo wp_kses_post( $instance['short_desciption'] ); ?></p>
                    <?php endif; ?>
                </div>
                <?php
            echo wp_kses_post($args['after_widget']);
    	}
    
    	public function update($new_instance, $old_instance) {
    		$instance = $old_instance;
    		$instance['title']              = sanitize_text_field($new_instance['title']);
            $instance['short_desciption']   = wp_kses_post($new_instance['short_desciption']);
            $instance['image_uri']          = esc_url_raw($new_instance['image_uri']);
    		return $instance;
    	}
    
    	public function form($instance)
        {
    		//Defaults
            $default = array(
                'title' => '',
                'about_title' => '',
                'short_desciption' => '',
                'image_uri' => ''
            );
    		$instance           = wp_parse_args((array)$instance, $default);
            $title              = $instance['title'];
            $short_desciption   = $instance['short_desciption'];
            $image_uri          = $instance['image_uri']; ?>
            <p>
            	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            	<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
            <p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_name('short_desciption')); ?>">About me text:</label>
                <textarea rows="8" class="widefat" id="<?php echo esc_attr($this->get_field_id('short_desciption')); ?>" name="<?php echo esc_attr($this->get_field_name('short_desciption')); ?>"><?php echo wp_kses_post($short_desciption); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id('image_uri') ); ?>">Image:</label><br />
                <img class="custom_media_image widefat" src="<?php echo esc_url($image_uri); ?>" style="margin:0;padding:0;max-width:100px;float:left;display:inline-block" />
                <input type="text" class="widefat custom_media_url" name="<?php echo esc_attr( $this->get_field_name('image_uri') ); ?>" id="<?php echo esc_attr( $this->get_field_id('image_uri') ); ?>" value="<?php echo esc_url( $instance['image_uri'] ); ?>" style="margin-top:5px;"/>
                <input type="button" class="button button-primary custom_media_button" id="custom_media_button" name="<?php echo esc_attr( $this->get_field_name('image_uri') ); ?>" value="Upload Image" style="margin-top:5px;" />
            </p><?php
    	}
    }
    
    function aztheme_about_me_init() {
        register_widget( 'AZTheme_About_Me_Widget' );
    }
    
    add_action('widgets_init', 'aztheme_about_me_init');
}

