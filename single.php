<?php get_header(); ?>
  <div id="main">

   <div id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="post">
		<h2 class="post_title_h2"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		<div class="post_info_top">
			<span class="post_info_date"><?php _e('Posted on', 'dot-b'); ?> <?php the_time(get_option( 'date_format' )) ?></span>
			<span class="post_info_author"> <?php _e('by', 'dot-b'); ?> <?php the_author_posts_link(); ?></span>
			<?php edit_post_link(__('[ Edit ]'),'<span class="post_info_edit">','</span>'); ?>
		</div>
     <div class="post_content">
      <?php the_content(); ?>
	  <?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
     </div>
    </div>
	<div class="post_info_bootom">
		<span class="post_meta"><?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?></span>  
		<span class="post_readmore"><?php comments_popup_link(__('Leave a Reply ?', 'dot-b'),__('[ 1 Reply ]', 'dot-b'),__('[ % Replies ]', 'dot-b')); ?></span>	
	</div>
	<div class="post-nav">
		<span class="previous_post"><?php if (get_next_post()) : ?><?php next_post_link('%link') ?><?php else: ?><?php _e('Already the latest post!', 'dot-b'); ?><?php endif; ?></span>
		<span class="next_post"><?php if (get_previous_post()) : ?><?php previous_post_link('%link') ?><?php else: ?><?php _e('Already the last post!', 'dot-b'); ?><?php endif; ?></span>
	</div>
	
	
	
<?php endwhile; else: ?>
    <div class="post">
     <p><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
    </div>
<?php endif; ?>

    <div id="comments">
     <?php comments_template( '', true ); ?>
    </div>

   </div>
   <?php get_sidebar(); ?>
   <div class="clear"></div>
  </div>
<?php get_footer(); ?>