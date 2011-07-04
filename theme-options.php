<?php
// Default options values
$dotb_options = array(
	'dotb_rss_url' => '&copy; ' . date('Y') . ' ' . get_bloginfo('name'),
	'dotb_is_excerpt' => false,
	'dotb_is_ga' => false,
	'dotb_analytics_code' => ''
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

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false; // This checks whether the form has just been submitted. ?>

	<div class="wrap">

	<?php screen_icon(); echo "<h2>" . get_current_theme() . __( ' Theme Options' ) . "</h2>";
	// This shows the page's name and an icon if one has been provided ?>

	<?php if ( false !== $_REQUEST['updated'] ) : ?>
	<div class="updated fade"><p><strong><?php _e( 'Options saved' ); ?></strong></p></div>
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
	<input id="dotb_rss_url" name="dotb_options[dotb_rss_url]" type="text" value="<?php  esc_attr_e($settings['dotb_rss_url']); ?>" />( With "<code>http://</code>" )   Keep blank to use WordPress default Rss Feed URL.</label>
	</td>
	</tr>

	<tr valign="top"><th scope="row">Enable Excerpt</th>
	<td><label for="dotb_is_excerpt">
	<input type="checkbox" id="dotb_is_excerpt" name="dotb_options[dotb_is_excerpt]" value="1" <?php checked( true, $settings['dotb_is_excerpt'] ); ?> />
	Show Author Credits</label>
	</td>
	</tr>
	
	<tr valign="top"><th scope="row">Use Google Analytics?</th>
	<td><label for="dotb_is_ga">
	<input type="checkbox" id="dotb_is_ga" name="dotb_options[dotb_is_ga]" value="1" <?php checked( true, $settings['dotb_is_ga'] ); ?> />
	You can get you GA code <a target="_blank" href="https://www.google.com/analytics/settings/check_status_profile_handler">here</a>.</label>
	</td>
	</tr>
	
	
	<tr valign="top"><th scope="row"><label for="dotb_analytics_code">Analytics Code</label></th>
	<td>
	<textarea id="dotb_analytics_code" name="dotb_options[dotb_analytics_code]" rows="5" cols="30"><?php echo stripslashes($settings['dotb_analytics_code']); ?></textarea>
	</td>
	</tr>



	</table>

	<p class="submit"><input type="submit" class="button-primary" value="Save Options" /></p>

	</form>

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
	
	// We strip all tags from the text field, to avoid vulnerablilties like XSS
	$input['dotb_analytics_code'] = wp_filter_post_kses( $input['dotb_analytics_code'] );
	
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