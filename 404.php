<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @Theme Dot-B
 */

get_header(); ?>
<div id="main">
	<div id="content">
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2 class="post_title_h2"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'dot-b' ); ?></h2>

			<div class="post_content">
				<?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'dot-b' ); ?>
				<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'widget_id' => '404' ) ); ?>

				<div class="widget">
					<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'dot-b' ); ?></h2>
					<ul>
					<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
					</ul>
				</div>

				<?php
				/* translators: %1$s: smilie */
				$archive_content = '<p>' .__( 'Try looking in the monthly archives.', 'dot-b' ) . '</p>';
				the_widget( 'WP_Widget_Archives', array('count' => 0 , 'dropdown' => 1 ), array( 'after_title' => '</h2>'.$archive_content ) );
				?>
				<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
			
			</div>
		</div>

	</div><!-- #content -->
<?php get_sidebar(); ?>
<div class="clear"></div>
</div><!-- #main -->
<?php get_footer(); ?>