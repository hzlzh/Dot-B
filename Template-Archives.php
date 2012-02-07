<?php
/*
Template Name: Template-Archives
*/
?>
<?php get_header(); ?>
<!--这里开始CSS样式定义-->

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

<!--这里开始实现功能-->
<div id="main">
	<div id="content">
			<!--核心代码开始-->
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h2 class="post_title_h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				</div>		
			<?php endwhile; else: ?>
				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h2 class="post_title_h2"><?php _e('Nothing Found', 'dot-b'); ?></h2>
				</div>
			<?php endif; ?>
	<span id="control">Expand All / Hide All</span>
				<div class="my-archive">
		<?php
			$previous_year = $year = 0;
			$previous_month = $month = 0;
			$ul_open = false;
			$myposts = get_posts('numberposts=-1&orderby=post_date&order=DESC');
		?>
		<?php foreach($myposts as $post) : ?>
		<?php
			setup_postdata($post);
			$year = mysql2date('Y', $post->post_date);
			$month = mysql2date('n', $post->post_date);
			$day = mysql2date('j', $post->post_date);
		?>
		<?php if($year != $previous_year || $month != $previous_month) : ?>
		<?php if($ul_open == true) : ?>
		</ul>
			<?php endif; ?>
			
			<ul class="month"><li><?php the_time('Y/m:'); ?></li></ul>
		<ul class="day">
			<?php $ul_open = true; ?>
			<?php endif; ?>
			<?php $previous_year = $year; $previous_month = $month; ?>
		<li><?php the_time('m-d'); ?> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <span class="comments_number">(<?php comments_number( '0', '1', '%' ); ?>)</span></li>
		<?php endforeach; ?>
		</ul>
				</div>

		<!--核心代码结束-->
	</div><!-- #content -->
<?php get_sidebar(); ?>
<div class="clear"></div>
</div><!-- #main -->
<!--这里开始jQuery-->


<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
		$('.my-archive ul.day:gt(2)').hide();//第0和1 列默认显示，其他默认隐藏
		$('.my-archive ul.month').click(function() {//点击标题动作
		$('.my-archive ul.day').slideUp(300);//展开选择列
		$(this).next('ul').slideDown(500);//缩放同级其他元素
		});
		//一下是全局的操作
		$('#control').toggle(
		function(){
			$('.my-archive ul.day').slideUp();
		},
		function(){
			$('.my-archive ul.day').slideDown();
		});
   });

	

</script>