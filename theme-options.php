<?php
$theme_data = get_theme_data(TEMPLATEPATH.'/style.css');
// Get author information

// Default options values
$temp_copyright = 'Copyright &copy; '.date("Y").'<a href="'.home_url( '/' ).'" title="'.esc_attr( get_bloginfo( 'name') ).'" rel="home">'.esc_attr( get_bloginfo( 'name') ).'</a>';

$dotb_options = array(
	'dotb_rss_url' => get_bloginfo('rss2_url'),
	'dotb_is_excerpt' => false,
	'dotb_is_ga' => false,
	'dotb_analytics_code' => '',
	'dotb_footer' => $temp_copyright,
	'dotb_is_sqlcount' => false,
	'dotb_version' => $theme_data['Version']
);

if ( is_admin() ) : // Load only if we are viewing an admin page

function dotb_register_settings() {
	// Register settings and call sanitation functions
	register_setting( 'dotb_theme_options', 'dotb_options', 'dotb_validate_options' );
}

add_action( 'admin_init', 'dotb_register_settings' );

// Store categories in array

function dotb_theme_options() {
	// Add theme options page to the addmin menu
	add_theme_page( 'Theme Options', 'Theme Options', 'edit_theme_options', 'theme_options', 'dotb_theme_options_page' );
}

add_action( 'admin_menu', 'dotb_theme_options' );

// Function to generate options page
function dotb_theme_options_page() {
	global $dotb_options;
	print_r($_REQUEST);
	if ( ! isset( $_REQUEST['settings-updated'] ) )
		$_REQUEST['settings-updated'] = false;
	else if( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) 
		delete_option( 'dotb_options' );
	// This checks whether the form has just been submitted. 
?>

	<div class="wrap">
	<style>
	textarea,input[type='text']{width:50%;}
	</style>
	<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
	// This shows the page's name and an icon if one has been provided ?>
	<?php if ( isset( $_REQUEST['action'])&&('reset' == $_REQUEST['action']) ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options reset successfully!' ); ?></strong></p></div>
	<?php elseif ( $_REQUEST['settings-updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved successfully!' ); ?></strong></p></div>
	<?php endif; // If the form has just been submitted, this shows the notification ?>
	
	<form method="post" action="options.php">

	<?php $settings = get_option( 'dotb_options', $dotb_options ); ?>
	
	<?php settings_fields( 'dotb_theme_options' );
	/* This function outputs some hidden fields required by the form,
	including a nonce, a unique number used to ensure the form has been submitted from the admin page
	and not somewhere else, very important for security */ ?>
	<table class="form-table"><!-- Grab a hot cup of coffee, yes we're using tables! -->
	<tbody>

	
	<tr valign="top"><th scope="row">Rss Feed URL</th>
	<td><label for="dotb_rss_url">
	<input id="dotb_rss_url" name="dotb_options[dotb_rss_url]" type="text" value="<?php esc_attr_e($settings['dotb_rss_url']); ?>" /><br>( With "<code>http://</code>" )   Keep blank to use WordPress default Rss Feed URL.</label>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Enable Excerpt</th>
	<td><label for="dotb_is_excerpt">
	<input type="checkbox" id="dotb_is_excerpt" name="dotb_options[dotb_is_excerpt]" value="1" <?php checked( true, $settings['dotb_is_excerpt'] ); ?> />
	Show excerpt in Home and Archives</label>
	</td>
	</tr>
	
	
	<tr valign="top"><th scope="row">Use Google Analytics?</th>
	<td><label for="dotb_is_ga">
	<input type="checkbox" id="dotb_is_ga" name="dotb_options[dotb_is_ga]" value="1" <?php checked( true, $settings['dotb_is_ga'] ); ?> />
	You can get you <code>Google Analytics</code> code <a target="_blank" href="https://www.google.com/analytics/settings/check_status_profile_handler">here</a>.</label>
	</td>
	</tr>
	
	
	<tr valign="top"><th scope="row"><label for="dotb_analytics_code">Analytics Code</label></th>
	<td>
	<textarea id="dotb_analytics_code" name="dotb_options[dotb_analytics_code]" rows="5" cols="30"><?php echo stripslashes($settings['dotb_analytics_code']); ?></textarea>
	</td>
	</tr>

	<tr valign="top"><th scope="row"><label for="dotb_footer">Footer Copyright</label></th>
	<td>
	<textarea id="dotb_footer" name="dotb_options[dotb_footer]" rows="5" cols="30"><?php echo stripslashes($settings['dotb_footer']); ?></textarea><p><strong>Preview:&nbsp;&nbsp;</strong><?php echo stripslashes($settings['dotb_footer']); ?></p>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Display SQL count at footer?</th>
	<td><label for="dotb_is_sqlcount">
	<input type="checkbox" id="dotb_is_sqlcount" name="dotb_options[dotb_is_sqlcount]" value="1" <?php checked( true, $settings['dotb_is_sqlcount'] ); ?> />
	<strong>Preview:&nbsp;&nbsp;</strong><code>{ 29 <?php _e("queries in");?> 1.018 <?php _e("seconds");?> }</code>
	</label>
	</td>
	</tr>
	
	
	</table>
	<input name="dotb_options[dotb_version]" type="hidden" value="<?php echo $settings['dotb_version']; ?>">
	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>
	</form>
	<form method="post">
	<p class="submit">
	<input class="button" name="reset" type="submit" value="Reset All Settings" />
	<input type="hidden" name="action" value="reset" />
	</p>
	</form>
	<div class="tips">
	<div id="icon-edit" class="icon32"><br></div>
	<h2>Some Tips Here</h2>
	<ul>
		<li>1.Your threaded (nested) comments <strong>[<?php echo get_option('thread_comments_depth');?>]</strong> levels deep, change it here -> <a target="_blank" href="./options-discussion.php">[<?php _e('Setting'); ?>]->[<?php _e('Discussion'); ?>]</a>, if you want</li>
		<li>2.You can change <code>&lt;Body&gt;</code> background image here -> <a target="_blank" href="./themes.php?page=custom-background">[<?php _e('Appearance'); ?>]->[<?php _e('Background'); ?>]</a>  </li>
		<li></li>
		<li></li>
	</ul>
	</div>
<div class="updated" id="donate">
<div style="text-align: center;">
		<span style="font-size: 20px;margin: 5px 0;display: block;"><a href="http://zlz.im/">Dot-B v<?php echo esc_attr_e($settings['dotb_version']);?></a></span>
		<br>
		Created, Developed and maintained by <a href="http://zlz.im/">HzlzH</a><br>
		If you like the <code>Dot-B</code> theme, please donate.  It will help in developing new features and versions.		<table style="margin:0 auto;">
			<tbody><tr>
				<td style="width:200px;">
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_donations">
					<input type="hidden" name="business" value="admin@hzlzh.com">
					<input type="hidden" name="lc" value="US">
					<input type="hidden" name="item_name" value="HzlzH's WordPress Dev">
					<input type="hidden" name="item_number" value="thanks 02">
					<input type="hidden" name="no_note" value="0">
					<input type="hidden" name="currency_code" value="USD">
					<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
					</form>

				</td>
				
			</tr>
		</tbody></table>
	</div>
</div>
	</div>

	<?php
}

function dotb_validate_options( $input ) {
	global $dotb_options;

	$settings = get_option( 'dotb_options', $dotb_options );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['dotb_rss_url'] = wp_filter_nohtml_kses( $input['dotb_rss_url'] );
	
	if ( ! isset( $input['dotb_is_excerpt'] ) )
	$input['dotb_is_excerpt'] = null;
	// We verify if the input is a boolean value
	$input['dotb_is_excerpt'] = ( $input['dotb_is_excerpt'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['dotb_is_ga'] ) )
	$input['dotb_is_ga'] = null;
	// We verify if the input is a boolean value
	$input['dotb_is_ga'] = ( $input['dotb_is_ga'] == 1 ? 1 : 0 );
	
	if ( ! isset( $input['dotb_is_sqlcount'] ) )
	$input['dotb_is_sqlcount'] = null;
	// We verify if the input is a boolean value
	$input['dotb_is_sqlcount'] = ( $input['dotb_is_sqlcount'] == 1 ? 1 : 0 );
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	//$input['dotb_analytics_code'] = wp_filter_post_kses( $input['dotb_analytics_code'] );
	
	// We select the previous value of the field, to restore it in case an invalid entry has been given
	/*
	$prev = $settings['featured_cat'];
	// We verify if the given value exists in the categories array
	
	if ( !array_key_exists( $input['featured_cat'], $dotb_categories ) )
		$input['featured_cat'] = $prev;
	
	// We select the previous value of the field, to restore it in case an invalid entry has been given
	$prev = $settings['layout_view'];
	// We verify if the given value exists in the layouts array
	if ( !array_key_exists( $input['layout_view'], $dotb_layouts ) )
		$input['layout_view'] = $prev;

	// If the checkbox has not been checked, we void it
	if ( ! isset( $input['author_credits'] ) )
		$input['author_credits'] = null;
	// We verify if the input is a boolean value
	$input['author_credits'] = ( $input['author_credits'] == 1 ? 1 : 0 );
		*/
	return $input;
}

endif;  // EndIf is_admin()