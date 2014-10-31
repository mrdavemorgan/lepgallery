<?php

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Settings:
    add_options_page(__('UnGallery','ungallery_menu'), __('UnGallery','ungallery_menu'), 'manage_options', 'ungallerysettings', 'mt_settings_page');
}

// mt_settings_page() displays the page content for the Test settings submenu
function mt_settings_page() {
	
    //must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }	

	// form hidden variable
	$hidden_field_name = 'mt_submit_hidden';
    
    // variables for the version field  
    $version_name = 'version';
    $version_data_field_name = 'version';

    // variables for the columns field  
    $columns_name = 'columns';
    $columns_data_field_name = 'columns';

    // variables for the thumbnail width field  
    $thumbnail_name = 'thumbnail';
    $thumbnail_data_field_name = 'thumbnail';

    // variables for the web view width field  
    $browse_view_name = 'browse_view';
    $browse_view_data_field_name = 'browse_view';

    // variables for the max_thumbs field  
    $max_thumbs_name = 'max_thumbs';
    $max_thumbs_data_field_name = 'max_thumbs';

    // variables for the watermark field  
    $watermark_name = 'watermark_image';
    $watermark_data_field_name = 'watermark_image';

    // variables for the columns field  
    $breadcrumb_separator_name = 'breadcrumb_separator';
    $breadcrumb_separator_data_field_name = 'breadcrumb_separator';

    // Read in existing option value from database
    $version_val = get_option( $version_name );
    $columns_val = get_option( $columns_name );
    $thumbnail_val = get_option( $thumbnail_name );
    $browse_view_val = get_option( $browse_view_name );
    $max_thumbs_val = get_option( $max_thumbs_name );
    $watermark_val = get_option( $watermark_name );
    $breadcrumb_separator_val = get_option( $breadcrumb_separator_name );

    // Apply defaults to form if db field is blank 
    if ($columns_val == "") $columns_val = "3";
    if ($thumbnail_val == "") $thumbnail_val = "190";
    if ($browse_view_val == "") $browse_view_val = "440";
    if ($max_thumbs_val == "") $max_thumbs_val = "10";
    if ($breadcrumb_separator_val == "") $breadcrumb_separator_val = " / ";

    // See if the user has submitted information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read the form values
        $columns_val = $_POST[ $columns_data_field_name ];
        $thumbnail_val = $_POST[ $thumbnail_data_field_name ];
        $browse_view_val = $_POST[ $browse_view_data_field_name ];
        $max_thumbs_val = $_POST[ $max_thumbs_data_field_name ];
        $watermark_val = $_POST[ $watermark_data_field_name ];
        $breadcrumb_separator_val = $_POST[ $breadcrumb_separator_data_field_name ];

        // Save the new values in the database
        update_option( $version_name, $version_val );
        update_option( $columns_name, $columns_val );
        update_option( $thumbnail_name, $thumbnail_val );
        update_option( $browse_view_name, $browse_view_val );
        update_option( $max_thumbs_name, $max_thumbs_val );
        update_option( $watermark_name, $watermark_val );
        update_option( $breadcrumb_separator_name, $breadcrumb_separator_val );

        update_option( 'thumb_square', $_POST[ 'thumb_square' ] );

        // Put settings updated message on the screen

?>
<div class="updated"><p><strong><?php _e('settings saved.', 'images_path' ); ?></strong></p></div>
<?php

    }

    // Now display the settings editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'UnGallery Plugin Settings', 'images_path' ) . "</h2>";

    // settings form

?>

<h3>General Settings</h3>	
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

UnGallery version: <input type="text" readonly name="<?php echo $version_name; ?>" value="<?php echo $version_val; ?>" size="10"><br />

<p>Gallery cache directory: <input type="text" readonly name="cache_dir" value="
<?php // Create cache directory at ./<WordPress install dir>/wp-content/cache/
if (!is_dir($_SERVER['DOCUMENT_ROOT']."/wp-content/cache/")) {
		@mkdir($_SERVER['DOCUMENT_ROOT']."/wp-content/cache/");
		if (!is_dir($_SERVER['DOCUMENT_ROOT']."/wp-content/cache/")) print "Could not create cache directory";
		else {
			@chmod($_SERVER['DOCUMENT_ROOT']."/wp-content/cache/", 0700); 
			$file = $_SERVER['DOCUMENT_ROOT']."/wp-content/cache/.htaccess";
			file_put_contents($file, 'AuthType Basic
AuthName "Password Required"
AuthUserFile /does_not_exist
Require valid-user');
			@chmod($file, 0700);
			print $_SERVER['DOCUMENT_ROOT']."/wp-content/cache/";
		}
} else 	print $_SERVER['DOCUMENT_ROOT']."/wp-content/cache/";
?>" size="70"> <br />
This is the directory where UnGallery creates and writes cache files.

<hr />

<h3>Tips and Troubleshooting</h3>

UnGallery faces a unique plugin challenge in leaving the WordPress environment to connect to your image library.  If your gallery does not display immediately, please check below for common solutions.  More info is available via the <a href="http://wordpress.org/extend/plugins/ungallery/faq/">FAQ</a>, <a href="http://wordpress.org/extend/plugins/ungallery/">plugin home page,</a> and <a href="http://wordpress.org/tags/ungallery">support forum</a>.  If you have any questions about configuring, using, or improving UnGallery please visit.
<p>
	<strong>Path</strong><br /> 
	WordPress hosting environments can differ greatly, so here are a few path tips: <br />
	&nbsp;1. Use the absolute path from the root like: /home/users/your_domain/images/ not relative to your website like: ../images/<br />
	&nbsp;2. The trailing slash/ is required. <br />
	&nbsp;3. You can find the full path to a directory on a linux system, by typing 'pwd' at the command prompt.  <br />
	&nbsp;4. On your server, this path to this admin page is: <b><?php print getcwd() ?>/ </b><br />
</p>

<p>
	<strong>Cache Directory</strong><br /> 
	If the cache directory field above says unable to create cache directory a permission setting may be the issue.  UnGallery will work without the cache directory, but performance is much better with it set.  It can be created manually at [WordPress Install]/wp-content/cache/.  A remote file management tool like <a href="http://winscp.net/eng/index.php">WinSCP</a> or <a href="http://cyberduck.ch/">Cyberduck</a> can be used or from the Linux shell in the Wordpress directory the following commands can be used: <br />
	&nbsp;&nbsp;mkdir wp-content/cache/<br />
	&nbsp;&nbsp;chmod 777 wp-content/cache/<br />
</p>

<p>
	<strong>Linux Only</strong><br />
	The majority of hosting providers run WordPress on Linux so that platform was chosen.  UnGallery for WordPress running on Windows operating and file systems is almost an entirely separate plugin development process.  If you notice issues with custom permalinks or are unsure of what platform your provider uses to publish WordPress, you can check by typing your website address into an analyzer like <a href="http://www.webconfs.com/http-header-check.php">this one</a>.
</p>

<hr />

<h3>Layout Settings</h3>
<p><?php _e("Breadcrumb separator:", 'breadcrumb_separator' ); ?> 
<input type="text" name="<?php echo $breadcrumb_separator_data_field_name; ?>" value="<?php echo $breadcrumb_separator_val; ?>" size="10">
Default: /
</p>

<p><?php _e("Number of thumbnail columns:", 'columns' ); ?> 
<input type="text" name="<?php echo $columns_data_field_name; ?>" value="<?php echo $columns_val; ?>" size="10">
Default: 3
</p>

<p><?php _e("Thumbnail width in pixels:", 'thumbnail' ); ?> 
<input type="text" name="<?php echo $thumbnail_data_field_name; ?>" value="<?php echo $thumbnail_val; ?>" size="10">
Default: 190
</p>

<p><?php _e("Crop thumbnails to sqaure:", 'square' ); ?> 
    <input name="thumb_square" id="thumb_square" value="true" type="checkbox" <?php 
    if ( get_option('thumb_square') == 'true' ) echo ' checked="checked" '; 
    ?> /> 
</p>

<p><?php _e("Selected picture width in pixels:", 'browse_view' ); ?> 
<input type="text" name="<?php echo $browse_view_data_field_name; ?>" value="<?php echo $browse_view_val; ?>" size="10">
Default: 440
</p>

<p><?php _e("Only show a maximum number of thumbnails per gallery page.  Maximum:", 'max_thumbs' ); ?> 
<input type="text" name="<?php echo $max_thumbs_data_field_name; ?>" value="<?php echo $max_thumbs_val; ?>" size="10">
Default: 10
</p><hr />

<h3>Advanced Options</h3>

<p><?php _e("Path to watermark image file:", 'watermark_image' ); ?>
<input type="text" name="<?php echo $watermark_data_field_name; ?>" value="<?php echo $watermark_val; ?>" size="70">  <br />
Full path on the local filesystem.  (Leave this empty to have no watermark.) * See path tips above for help.
</p>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}

?>