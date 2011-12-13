<?php
/*
Template Name: Template-Collection
*/
?>
<?php get_header(); ?>
<!-- CSS style begin -->

<style type="text/css">
#control{
			color: #BD0800;
		    cursor: row-resize;
		    padding-left: 10px;
		    text-shadow: 0 0 1px #FFFFFF;
		
		}
.my-archive{
	margin: 10px;
}
.my-archive h3 span{
    color: #555;
    cursor: move;
    margin-top: 3px;
    padding: 3px 5px;
}
.my-archive ul.day li{
    list-style: circle inside none;
    padding-left: 15px;
    padding-top: 2px;

}
.my-archive ul.month li{
list-style: square inside none;
cursor: s-resize;

}
.comments_number{
	color:#999;
}
</style>

<!-- Function begin -->
<div id="main">
	<div id="content">
			<!-- core code begin -->

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post_title_h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<div class="post_content">
			<?php the_content(); ?>
			<?php wp_link_pages('before=<div id="page-links">&after=</div>'); ?>
		</div>
	</div>		
<?php endwhile; else: ?>
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<h2 class="post_title_h2"><?php _e('Nothing Found', 'dot-b'); ?></h2>
	</div>
<?php endif; ?>

		<!-- core code end-->
	</div><!-- #content -->
<?php get_sidebar(); ?>
<div class="clear"></div>
</div><!-- #main -->
<!-- jQuery begin -->


<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
		$('.my-archive ul.day:gt(2)').hide();
		$('.my-archive ul.month').click(function() {
		$('.my-archive ul.day').slideUp(300);
		$(this).next('ul').slideDown(500);
		});
		//for all the emelents
		$('#control').toggle(
		function(){
			$('.my-archive ul.day').slideUp();
		},
		function(){
			$('.my-archive ul.day').slideDown();
		});
   });
</script>