<?php
load_theme_textdomain( 'dot-b', TEMPLATEPATH . '/languages' );
require_once ( TEMPLATEPATH . '/theme-options.php' );

// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// This theme allows users to set a custom background
add_custom_background();

// Your changeable header business starts here.
if ( ! defined( 'HEADER_TEXTCOLOR' ) )
	define( 'HEADER_TEXTCOLOR', '' );

// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
if ( ! defined( 'HEADER_IMAGE' ) )
	define( 'HEADER_IMAGE', '%s/images/headers/inkwell.jpg' );

// The height and width of your custom header. You can hook into the theme's own filters to change these values.
// Add a filter to dotb_header_image_width and dotb_header_image_height to change these values.
define( 'HEADER_IMAGE_WIDTH', apply_filters( 'dotb_header_image_width', 958 ) );
define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'dotb_header_image_height', 198 ) );

// We'll be using post thumbnails for custom header images on posts and pages.
// We want them to be 940 pixels wide by 198 pixels tall.
// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

if ( ! isset( $content_width ) )
	$content_width = 670;
	
// This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'extra-featured-image', 620, 200, true );
function dotb_featured_content($content) {
	if (is_single() || is_home() || is_archive()) {
		the_post_thumbnail( 'extra-featured-image' );
	}
	return $content;
}
add_filter( 'the_content', 'dotb_featured_content',1 );

// Don't support text inside the header image.
if ( ! defined( 'NO_HEADER_TEXT' ) )
	define( 'NO_HEADER_TEXT', true );
	
add_custom_image_header( '', 'dotb_admin_header_style' );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'house' => array(
			'url' => '%s/images/headers/house.jpg',
			'thumbnail_url' => '%s/images/headers/house-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'House', 'dot-b' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'dot-b' )
		),
		'willow' => array(
			'url' => '%s/images/headers/willow.jpg',
			'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Willow', 'dot-b' )
		),
		'shore' => array(
			'url' => '%s/images/headers/shore.jpg',
			'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Shore', 'dot-b' )
		),
		'sky' => array(
			'url' => '%s/images/headers/sky.jpg',
			'thumbnail_url' => '%s/images/headers/sky-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sky', 'dot-b' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'dot-b' )
		),
	) );

// Register nav_menu
if ( function_exists('register_nav_menu') ) { 
	register_nav_menus(
		array(
		  'primary' => __( 'Header Menu', 'dot-b' ),
		  'social_media' => __( 'Custom Social Media', 'dot-b' )
		)
	);
}

// Register sidebar
register_sidebar(array(
	'before_widget' => '<li id="%1$s" class="widget %2$s">'."\n",
	'after_widget' => "</li>\n",
	'before_title' => '<h3 class="widget_title">',
	'after_title' => "</h3>\n",
	'name' => __('SideBar', 'dot-b' ),
	'id' => 'right-sidebar'
));


if ( ! function_exists( 'dotb_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in dotb_setup().
 *
 */
function dotb_admin_header_style() {
?>
	<style type="text/css">
	/* Shows the same border as on front end */
	#headimg {
		border-bottom: 1px solid #000;
		border-top: 4px solid #000;
	}
	/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
		#headimg #name { }
		#headimg #desc { }
	*/
	</style>
<?php
}
endif;

// Wp_tag_cloud Widget
function dotb_colorfultagcloud($text) { 
	$text = preg_replace_callback('|<a (.+?)>|i', 'dotb_colorfultagcloudcallback', $text);
	return $text;
	}
function dotb_colorfultagcloudcallback($matches) { 
	$text = $matches[1];
	$color = dechex(rand(0,16777215));// Here you can control the color of tags
	$pattern = '/style=(\'|\")(.*)(\'|\")/i';
	$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
	return "<a $text>";
}

// Custom Comments List.
function dotb_mytheme_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	if ( $post = get_post($post_id) ) {
                       if ( $comment->user_id === $post->post_author )
                               $bypostauthor = 'by-post-author'; else $bypostauthor = 'by-vistor';
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

		<div class="comment-content"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
	?>
	<li class="pings pingback">
        <?php comment_author_link(); ?> - Pingback on <?php echo mysql2date('Y/m/d/ H:i', $comment->comment_date); ?>
	<?php
			break;
		case 'trackback' :
	?>
	<li class="pings trackback">
        <?php comment_author_link(); ?> - Trackback on <?php echo mysql2date('Y/m/d/ H:i', $comment->comment_date); ?>
	<?php
			break;
	endswitch;
}

?>
<?php
class dotb_widget_colorfultagcloud extends WP_Widget {
    function dotb_widget_colorfultagcloud() {
        $widget_ops = array('description' => 'Dot-B '.__( 'Display Colorful Tags Cloud', 'dot-b'));
        $this->WP_Widget('dotb_widget_colorfultagcloud', 'Dot-B '.__( 'Colorful Tag Cloud', 'dot-b'), $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', esc_attr($instance['title']));
        echo $before_widget.$before_title.$title.$after_title;
        echo '<div class="colorfultagcloud">';
		add_filter('wp_tag_cloud', 'dotb_colorfultagcloud', 1);
		wp_tag_cloud();
        echo '</div>';
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title' => __( 'Tag Cloud', 'dot-b')));
        $title = esc_attr($instance['title']);
?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'dot-b'); ?>:<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
<?php
    }
}
add_action('widgets_init', 'dotb_widget_colorfultagcloud_init');
function dotb_widget_colorfultagcloud_init() {
    register_widget('dotb_widget_colorfultagcloud');
}
// Redirect to theme options page after theme activation.
global $pagenow;
if(is_admin() && isset($_GET['activated']) && $pagenow = 'themes.php') {
	header('Location: '.admin_url().'themes.php?page=theme_options' );
}
?>