<?php
global $dotb_options;
$dotb_settings = get_option( 'dotb_options', $dotb_options );
?>
<?php get_header(); ?>
<div id="main">
	<div id="content">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2 class="post_title_h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<div class="post_info_top">
				<div class="post_info_date"> <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark"><?php printf( __('Posted on %s', 'dot-b'), get_the_date(get_option( 'date_format' ))); ?></a></div>
				<div class="post_info_author"> <?php _e('by', 'dot-b'); ?> <?php the_author_posts_link(); ?></div>
				<?php edit_post_link(__('[ Edit ]', 'dot-b'),'<span class="post_info_edit">','</span>'); ?>
			</div>
			<div class="post_content">
				<?php if ( $dotb_settings['dotb_is_excerpt']=='1' ) { the_excerpt(__('Read more &raquo;','dot-b')); } else { the_content(__('Read more &raquo;','dot-b')); }?>
				<?php wp_link_pages(); ?>
			</div>
		</div>
		<div class="post_info_bootom">
			<div class="post_meta"><?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?></div>  
			<div class="post_readmore"><?php comments_popup_link(__('Leave a Reply ?', 'dot-b'),__('[ 1 Reply ]', 'dot-b'),__('[ % Replies ]', 'dot-b')); ?></div>	
		</div>		
	<?php endwhile; else: ?>
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
	<?php endif; ?>
	<?php if (function_exists('wp_pagenavi')) { wp_pagenavi(); } else { get_template_part( 'navigation'); } ?>
	</div><!-- #content -->
<?php get_sidebar(); ?>
<div class="clear"></div>
</div><!-- #main -->
<?php get_footer(); ?> 