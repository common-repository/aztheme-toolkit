<?php
if ( ! class_exists( 'AZTheme_Latest_Posts_Widget' ) ) {
    class AZTheme_Latest_Posts_Widget extends WP_Widget {
    	function __construct() {
    		$widget_ops = array( 'classname' => 'aztheme-latest-posts-widget', 'description' => __('A widget that displays your latest posts from all categories or a certain', 'aztheme-toolkit') );
    		parent::__construct( 'aztheme-latest-posts-widget', __('AZ-Theme: Latest Posts', 'aztheme-toolkit'), $widget_ops );
    	}
    
    	function widget( $args, $instance ) {
    		extract( $args );
    		$title        = apply_filters('widget_title', $instance['title'] );
    		$categories   = $instance['categories'];
    		$number       = $instance['number'];
    		$query        = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'cat' => $categories);		
    		$loop         = new WP_Query($query);
    
    		if ( $loop->have_posts() ) {
                $c = 0;
        		echo wp_kses_post( $before_widget );
        		if ( $title ) {
        		    echo wp_kses_post( $before_title . $title . $after_title );
        		} ?>
    			<ul>
    			<?php  while ( $loop->have_posts() ) { $loop->the_post(); $c++; ?>
    				<li>
                        <article <?php post_class(); ?>>
                            <div class="entry-left">
                                <h4 class="entry-title">
                                    <a href="<?php the_permalink() ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <div class="entry-meta">
                                    <div class="entry-date"><?php echo  get_the_date(); ?></div>                                
                                </div>
                            </div>
                            <a class="entry-image" href="<?php the_permalink() ?>">
                                <span><?php echo esc_html( $c ); ?></span>
                                <?php
                                    if ( get_the_post_thumbnail() ) {
                                        the_post_thumbnail( 'thumbnail' );
                                    }
                                ?>
                            </a>
                        </article>
    				</li>
    			<?php } ?>
                </ul><?php
                wp_reset_postdata();
                echo wp_kses_post( $after_widget );
            }
    	}
    
    	function update( $new_instance, $old_instance ) {
    		$instance = $old_instance;
    		$instance['title']        = sanitize_text_field( $new_instance['title'] );
    		$instance['categories']   = sanitize_text_field( $new_instance['categories'] );
    		$instance['number']       = absint( $new_instance['number'] );
    		return $instance;
    	}
    
    	function form( $instance )
        {
    		$defaults = array( 'title' => esc_html__('Latest Posts', 'aztheme-toolkit'), 'number' => 5, 'categories' => '');
    		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
    		<p>
    			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e('Title:', 'aztheme-toolkit'); ?></label>
    			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>"  />
    		</p>
    		<p>
        		<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>">Filter by Category:</label> 
        		<select id="<?php echo esc_attr( $this->get_field_id('categories') ); ?>" name="<?php echo esc_attr( $this->get_field_name('categories') ); ?>" class="widefat categories" style="width:100%;">
        			<option value="all" <?php selected( $instance['categories'], 'all' );?>>All categories</option>
        			<?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
        			<?php foreach($categories as $category) { ?>
        			<option value="<?php echo esc_attr( $category->term_id ); ?>" <?php selected( $instance['categories'], $category->term_id );?>><?php echo esc_html( $category->cat_name ); ?></option>
        			<?php } ?>
        		</select>
    		</p>
    		<p>
    			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e('Number of posts to show:', 'aztheme-toolkit'); ?></label>
    			<input  type="number" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3" />
    		</p>
    	<?php
    	}
    }
    
    function aztheme_latest_posts_init() {
    	register_widget( 'AZTheme_Latest_Posts_Widget' );
    }
    
    add_action( 'widgets_init', 'aztheme_latest_posts_init' );
}

