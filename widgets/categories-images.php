<?php
if ( ! class_exists( 'AZTheme_Categories_Images_Widget' ) ) {
    class AZTheme_Categories_Images_Widget extends WP_Widget {
        public function __construct() {
            $widget_ops = array(
                'classname'   => 'aztheme-categories-images',
                'description' => __('Categories Images Widget', 'aztheme-toolkit')
            );
            
            parent::__construct( 'aztheme-categories-images', 'AZ-Theme: Categories Images', $widget_ops );
        }
    
        public function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            echo wp_kses_post($before_widget);
            $title          = isset( $instance['title'] ) ? $instance['title'] : '';
            $order          = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
            $orderby        = isset( $instance['orderby'] ) ? $instance['orderby'] : 'count';
            $term_ids       = isset( $instance['categories'] ) ? $instance['categories'] : array();
            
            $args = array(
              'orderby'     => $orderby,  
              'order'       => $order,
              'include'    => $term_ids
            );
            
            $categories = get_categories($args);
    
            if ( ! empty( $categories ) ) {
                if ( $title ) {
                    echo wp_kses_post( $before_title . $title . $after_title );
                }
                ?>
        		<ul>
                    <?php
                        foreach ($categories as $cat) {
                            $bg_image = aztheme_toolkit_category_image($cat->term_id); ?>
                			<li class="category-item" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
                				<a href="<?php echo esc_url( get_category_link($cat->term_id) ); ?>"><?php echo wp_kses_post($cat->name); ?>(<?php echo wp_kses_post($cat->count); ?>)</a>
                			</li>
                            <?php
                        }
                    ?>
        		</ul>
            	<?php
            }
            echo wp_kses_post($after_widget);
        }
        
        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title']      = sanitize_text_field($new_instance['title']);
            $instance['orderby']    = sanitize_text_field($new_instance['orderby']);
            $instance['order']      = sanitize_text_field($new_instance['order']);
            $instance['categories'] = $new_instance['categories'];
            return $instance;
        }
    
        public function form( $instance ) {        
            $title      = isset( $instance['title'] ) ? $instance['title'] : '';
            $orderby    = isset( $instance['orderby'] ) ? $instance['orderby'] : 'count';
            $order      = isset( $instance['order'] ) ? $instance['order'] : 'DESC';
            $categories = isset( $instance['categories'] ) ? $instance['categories'] : array();
            $categories_checkbox = get_categories( 'hide_empty=1&depth=1&type=post' );
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_name( 'title' )); ?>"><?php _e( 'Title:', 'aztheme-toolkit' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>
            <?php foreach( $categories_checkbox as $category ) { ?>
            <p>
    			<input type="checkbox" <?php if ( in_array( $category->term_id, $categories ) ) { ?>checked="checked"<?php } ?> name="<?php echo esc_attr($this->get_field_name( 'categories' )); ?>[]" value="<?php echo esc_attr( $category->term_id ); ?>" />
                <label for="<?php echo esc_attr( $this->get_field_id( 'categories' ) ); ?>"><?php echo wp_kses_post( $category->cat_name . '('. $category->count .')' ); ?></label>
    		</p>
            <?php } ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>"><?php _e( 'Order By', 'aztheme-toolkit' ); ?></label>
                <select class='widefat' id="<?php echo esc_attr($this->get_field_id('orderby')); ?>" name="<?php echo esc_attr($this->get_field_name('orderby')); ?>">
                	<option value="term_id" <?php selected( $orderby, 'term_id' ); ?>><?php _e('ID', 'aztheme-toolkit'); ?></option>
                    <option value="name" <?php selected( $orderby, 'name' ); ?>><?php _e('Name', 'aztheme-toolkit'); ?></option>
                    <option value="count" <?php selected( $orderby, 'count' ); ?>><?php _e('Count', 'aztheme-toolkit'); ?></option>
                </select>
                <i><?php _e('Sort categories alphabetically, by unique Category ID, or by the count of posts in that Category', 'aztheme-toolkit'); ?></i>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_name( 'order' )); ?>"><?php _e( 'Order', 'aztheme-toolkit' ); ?></label>
                <select class='widefat' id="<?php echo esc_attr($this->get_field_id('order')); ?>" name="<?php echo esc_attr($this->get_field_name('order')); ?>">
                	<option value='ASC' <?php selected( $order, 'ASC' ); ?>><?php _e('ASC', 'aztheme-toolkit'); ?></option>
                    <option value='DESC'<?php selected( $order, 'DESC' ); ?>><?php _e('DESC', 'aztheme-toolkit'); ?></option>
                </select>
                <i><?php _e('Sort order for categories (either ascending or descending). The default is ascending', 'aztheme-toolkit'); ?></i>
            </p>
        <?php
        }
    }
    
    function aztheme_categories_images_widget_init() {
        register_widget( 'AZTheme_Categories_Images_Widget' );
    }
    
    add_action( 'widgets_init', 'aztheme_categories_images_widget_init' );
}
