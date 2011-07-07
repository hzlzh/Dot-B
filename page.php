<?php get_header(); ?>
  <div id="main">
   <div id="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div class="post">
     <h1 class="post_title_h2"><?php the_title(); ?></h1>
     <ul class="post_info">
      <?php if ($options['author']) : ?><li><?php _e('By'); ?> <?php the_author_posts_link(); ?></li><?php endif; ?>
      <?php edit_post_link(__('[ EDIT ]'), '<li class="post_edit">', '</li>' ); ?>
     </ul>
     <div class="post_content">
      <?php the_content(__('Read more')); ?>
      <?php wp_link_pages(); ?>
     </div>
    </div>
<?php endwhile; else: ?>
    <div class="post">
     <p><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>
    </div>
<?php endif; ?>

    <div id="comments_wrapper">
     <?php comments_template( '', true ); ?>
    </div>
   </div>
   <?php get_sidebar(); ?>
  </div>
<?php get_footer(); ?>