<div id="sidebar" class="widget-area" role="complementary">
	<ul class="xoxo">

<?php
/* When we call the dynamic_sidebar() function, it'll spit out
* the widgets for that widget area. If it instead returns false,
* then the sidebar simply doesn't exist, so we'll hard-code in
* some default sidebar stuff just in case.
*/
if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>

	<li id="calendar" class="widget-container">
		<?php the_widget('WP_Widget_Calendar', $instance, $args); ?> 
	</li>

	<li id="archives" class="widget-container">
		<h3 class="sidebar_title"><?php _e( 'Archives', 'dot-b' ); ?></h3>
		<ul>
			<?php wp_get_archives( 'type=monthly' ); ?>
		</ul>
	</li>
	<li id="recent-post" class="widget-container">
		<h3 class="sidebar_title"><?php _e( 'Recent Posts', 'dot-b' ); ?></h3>
		<ul>
		<?php
			$recent_posts = wp_get_recent_posts();
			foreach( $recent_posts as $post ){
				echo '<li><a href="' . get_permalink($post["ID"]) . '" title="Look '.$post["post_title"].'" >' .   $post["post_title"].'</a> </li> ';
			}
		?>
		</ul>
	</li>
	<li id="recent-comments" class="widget-container">
			<?php the_widget('WP_Widget_Recent_Comments', 'number', 'before_widget=&after_widget=&before_title=<h3 class="sidebar_title">&after_title =</h3>'); ?> 
	</li>	
	<li id="recent-comments" class="widget-container">
		<h3 class="sidebar_title"><?php _e( 'Archives', 'dot-b' ); ?></h3>
		<ul>
		<?php wp_tag_cloud('smallest=8&largest=22'); ?>
		</ul>
	</li>

	<li id="meta" class="widget-container">
		<h3 class="sidebar_title"><?php _e( 'Meta', 'dot-b' ); ?></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<?php wp_meta(); ?>
		</ul>
	</li>

<?php endif; // end primary widget area ?>
	</ul>
</div><!-- #primary .widget-area -->