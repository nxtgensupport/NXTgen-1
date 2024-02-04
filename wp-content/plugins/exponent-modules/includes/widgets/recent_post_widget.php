<?php
if( !class_exists( 'Exponent_Widget_Recent_Posts' ) ) {
	class Exponent_Widget_Recent_Posts extends WP_Widget {
		function __construct() {
			$widget_ops = array('classname' => 'exp-widget_recent_entries', 'description' => __( "The most recent posts on your site",'exponent') );
			parent::__construct('be-recent-posts', __('BE Recent Posts','exponent'), $widget_ops);
			$this->alt_option_name = 'widget_recent_entries';
		}

		function widget($args, $instance) {
			$cache = wp_cache_get('widget_recent_posts', 'widget');

			if ( !is_array($cache) )
				$cache = array();

			if ( ! isset( $args['widget_id'] ) )
				$args['widget_id'] = $this->id;

			if ( isset( $cache[ $args['widget_id'] ] ) ) {
				echo esc_attr( $cache[ $args['widget_id'] ] );
				return;
			}

			ob_start();
			extract($args);
			$title = apply_filters('be_recent_posts_widget_title', empty($instance['title']) ? __('Recent Posts', 'exponent' ) : $instance['title'], $instance, $this->id_base);
			if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
				$number = 10;
			$r = wp_get_recent_posts( 
				array(
					'numberposts' => $number, 
					'post_status' => 'publish',
					'suppress_filters' => empty( $instance['wpml_language'] )
					) 
				);
			
			echo wp_kses_post( $before_widget ); 
			if ( $title ) echo wp_kses_post( $before_title . $title . $after_title ); ?>
			<ul class="exp-recent-posts-widget">
				<?php
				foreach( $r as $recent_post ){
					$post_id = $recent_post["ID"];
					$permalink = get_permalink( $post_id );
					if( !$permalink ) {
						$permalink = '#';
					}
					$post_title = $recent_post["post_title"]; ?>
					<li class="exp-recent-posts-widget-post">
						<?php if( get_the_post_thumbnail( $post_id ) ) { ?>
							<div class="exp-recent-posts-widget-post-thumb">
								<a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($post_title ? $post_title : $post_id); ?>">
									<?php echo get_the_post_thumbnail($post_id, array( 75, 75 )); ?>
								</a>
							</div>
						<?php } ?>
						<div class = "exp-recent-posts-widget-post-details" >
							<div class="exp-recent-posts-widget-post-title">
								<a href="<?php echo esc_url($permalink); ?>" title="<?php echo esc_attr($post_title ? $post_title : $post_id); ?>">
									<?php echo be_themes_trim_content($post_title, 50); ?>
								</a>
							</div>
							<div class="exp-recent-posts-widget-post-date-with-icon">
								<div class = "exp-recent-posts-widget-post-date-icon">
									<i class = "exp-icon tatsu-icon-clock2">
									</i>
								</div>	
								<div class = "exp-recent-posts-widget-post-date">
									<?php echo get_the_date( 'M d, Y', $post_id );//date_format(date_create($recent_post["post_date"]), "F j, Y");?>
							</div>
						</div>
					</li><?php
				}?>
			</ul>
			<?php echo wp_kses_post( $after_widget ); 
			// Reset the global $the_post as this query will have stomped on it
			wp_reset_postdata();
			$cache[$args['widget_id']] = ob_get_flush();
			wp_cache_set('widget_recent_posts', $cache, 'widget');
		}

		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = (int) $new_instance['number'];
			//$this->flush_widget_cache();

			$alloptions = wp_cache_get( 'alloptions', 'options' );
			if ( isset($alloptions['widget_recent_entries']) )
				delete_option('widget_recent_entries');

			return $instance;
		}

		function form( $instance ) {
			$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
			$number = isset($instance['number']) ? absint($instance['number']) : 5;
			?>
			<p><label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:','exponent'); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

			<p><label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number of posts to show:','exponent'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($number); ?>" size="3" /></p>
		<?php
		}
    }
    
    if( !function_exists( 'exponent_modules_recent_posts_init' ) ) {
        function exponent_modules_recent_posts_init() {
            register_widget('Exponent_Widget_Recent_Posts');
        }
        add_action('widgets_init', 'exponent_modules_recent_posts_init');
    }

}