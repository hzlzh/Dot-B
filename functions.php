<?php
require_once ( get_stylesheet_directory() . '/theme-options.php' );
// Register nav_menu
if ( function_exists('register_nav_menu') ) { register_nav_menu('primary', 'header_menu'); }

// Register sidebar
register_sidebar(array(
	'before_widget' => '<li class="widget-container" id="%2$s">'."\n",
	'after_widget' => "</li>\n",
	'before_title' => '<h3 class="widget_title">',
	'after_title' => "</h3>\n",
	'name' => 'Sidebar',
	'id' => 'right-sidebar'
));

// Wp_tag_cloud Widget
function colorCloud($text) { 
$text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
return $text;
} 
function colorCloudCallback($matches) { 
$text = $matches[1];
$color = dechex(rand(0,16777215));//修改此处可以控制随机色彩值的范围
$pattern = '/style=(\'|\")(.*)(\'|\")/i';
$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
return "<a $text>";
} 
add_filter('wp_tag_cloud', 'colorCloud', 1);

// Custom Comments List.
function mytheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( $post = get_post($post_id) ) {
                       if ( $comment->user_id === $post->post_author )
                               $bypostauthor = 'by-post-author';
               }
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="<?php echo $bypostauthor;?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			<span class="comment-meta commentmetadata">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'dot-b' ), get_comment_date(),  get_comment_time() ); ?><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"> # </a><?php edit_comment_link( __( '(Edit)', 'dot-b' ), ' ' );
			?>
		</span><!-- .comment-meta .commentmetadata -->
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'dot-b' ); ?></em>
			<br />
		<?php endif; ?>



		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php comment_author_link(); ?> - <?php echo $comment->comment_type; ?> on <?php echo date("Y/m/d H:i",$comment->comment_date);?><?php edit_comment_link( __('(Edit)', 'dot-b'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}

?>