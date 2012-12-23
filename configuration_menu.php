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

    // variables for the gallery URL string field 
    $gallery_name = 'gallery';
    $gallery_data_field_name = 'gallery';

    // variables for the gallery URL string field 
    $gallery2_name = 'gallery2';
    $gallery2_data_field_name = 'gallery2';

    // variables for the gallery URL string field 
    $gallery3_name = 'gallery3';
    $gallery3_data_field_name = 'gallery3';

    // variables for the gallery URL string field 
    $gallery4_name = 'gallery4';
    $gallery4_data_field_name = 'gallery4';

    // variables for the gallery URL string field 
    $gallery5_name = 'gallery5';
    $gallery5_data_field_name = 'gallery5';

    // variables for the gallery URL string field 
    $gallery6_name = 'gallery6';
    $gallery6_data_field_name = 'gallery6';

    // variables for the path to images field  
    $path_name = 'images_path';
    $path_data_field_name = 'images_path';

    // variables for the path to images field  
    $path2_name = 'images2_path';
    $path2_data_field_name = 'images2_path';

    // variables for the path to images field  
    $path3_name = 'images3_path';
    $path3_data_field_name = 'images3_path';

    // variables for the path to images field  
    $path4_name = 'images4_path';
    $path4_data_field_name = 'images4_path';

    // variables for the path to images field  
    $path5_name = 'images5_path';
    $path5_data_field_name = 'images5_path';

    // variables for the path to images field  
    $path6_name = 'images6_path';
    $path6_data_field_name = 'images6_path';

    // variables for the hidden field  
    $hidden_name = 'hidden';
    $hidden_data_field_name = 'hidden';

    // variables for the thumbnail width field  
    $thumbnail_name = 'thumbnail';
    $thumbnail_data_field_name = 'thumbnail';

    // variables for the web view width field  
    $browse_view_name = 'browse_view';
    $browse_view_data_field_name = 'browse_view';

    // variables for the max_thumbs field  
    $max_thumbs_name = 'max_thumbs';
    $max_thumbs_data_field_name = 'max_thumbs';

    // Read in existing option value from database
    $version_val = get_option( $version_name );
    $gallery_val = get_option( $gallery_name );
    $gallery2_val = get_option( $gallery2_name );
    $gallery3_val = get_option( $gallery3_name );
    $gallery4_val = get_option( $gallery4_name );
    $gallery5_val = get_option( $gallery5_name );
    $gallery6_val = get_option( $gallery6_name );
    $path_val = get_option( $path_name );
    $path2_val = get_option( $path2_name );
    $path3_val = get_option( $path3_name );
    $path4_val = get_option( $path4_name );
    $path5_val = get_option( $path5_name );
    $path6_val = get_option( $path6_name );
    $hidden_val = get_option( $hidden_name );
    $columns_val = get_option( $columns_name );
    $thumbnail_val = get_option( $thumbnail_name );
    $browse_view_val = get_option( $browse_view_name );
    $movie_height_val = get_option( $movie_height_name );
    $movie_width_val = get_option( $movie_width_name );
    $max_thumbs_val = get_option( $max_thumbs_name );

    // Apply defaults to form if db field is blank 
    //if ($gallery_val == "") $gallery_val = "gallery";
    if ($hidden_val == "") $hidden_val = "hidden";
    if ($columns_val == "") $columns_val = "3";
    if ($thumbnail_val == "") $thumbnail_val = "190";
    if ($browse_view_val == "") $browse_view_val = "440";
    if ($movie_height_val == "") $movie_height_val = "495";
    if ($movie_width_val == "") $movie_width_val = "640";
    if ($max_thumbs_val == "") $max_thumbs_val = "10";

    // See if the user has submitted information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read the form values
        $gallery_val = $_POST[ $gallery_data_field_name ];
        $gallery2_val = $_POST[ $gallery2_data_field_name ];
        $gallery3_val = $_POST[ $gallery3_data_field_name ];
        $gallery4_val = $_POST[ $gallery4_data_field_name ];
        $gallery5_val = $_POST[ $gallery5_data_field_name ];
        $gallery6_val = $_POST[ $gallery6_data_field_name ];
        $path_val = $_POST[ $path_data_field_name ];
        $path2_val = $_POST[ $path2_data_field_name ];
        $path3_val = $_POST[ $path3_data_field_name ];
        $path4_val = $_POST[ $path4_data_field_name ];
        $path5_val = $_POST[ $path5_data_field_name ];
        $path6_val = $_POST[ $path6_data_field_name ];
        $hidden_val = $_POST[ $hidden_data_field_name ];
        $columns_val = $_POST[ $columns_data_field_name ];
        $thumbnail_val = $_POST[ $thumbnail_data_field_name ];
        $browse_view_val = $_POST[ $browse_view_data_field_name ];
        $movie_height_val = $_POST[ $movie_height_data_field_name ];
        $movie_width_val = $_POST[ $movie_width_data_field_name ];
        $max_thumbs_val = $_POST[ $max_thumbs_data_field_name ];

        // Save the new values in the database
        update_option( $version_name, $version_val );
        update_option( $gallery_name, $gallery_val );
        update_option( $gallery2_name, $gallery2_val );
        update_option( $gallery3_name, $gallery3_val );
        update_option( $gallery4_name, $gallery4_val );
        update_option( $gallery5_name, $gallery5_val );
        update_option( $gallery6_name, $gallery6_val );
        update_option( $path_name, $path_val );
        update_option( $path2_name, $path2_val );
        update_option( $path3_name, $path3_val );
        update_option( $path4_name, $path4_val );
        update_option( $path5_name, $path5_val );
        update_option( $path6_name, $path6_val );
        update_option( $hidden_name, $hidden_val );
        update_option( $columns_name, $columns_val );
        update_option( $thumbnail_name, $thumbnail_val );
        update_option( $browse_view_name, $browse_view_val );
        update_option( $movie_height_name, $movie_height_val );
        update_option( $movie_width_name, $movie_width_val );
        update_option( $max_thumbs_name, $max_thumbs_val );

        update_option( 'activate_fancybox', $_POST[ 'activate_fancybox' ] );
        update_option( 'disable_zip', $_POST[ 'disable_zip' ] );

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

<p><?php _e("Path to image directory:", 'images_path' ); ?>
<input type="text" name="<?php echo $path_data_field_name; ?>" value="<?php echo $path_val; ?>" size="70"> 	<br />
Full path including trailing slash/.  * See path tips below for help.
</p>

<p>Website: <input type="text" readonly name="URI" value="<? print get_bloginfo('url'); ?>/" size="40"><?php _e("", 'gallery' ); ?> 
Permalink: <input type="text" name="<?php echo $gallery_data_field_name; ?>" value="<?php echo $gallery_val; ?>" size="20"><br />
Match the permalink format of the page you created in step 2. Examples are "?page_id=4" and "gallery".<br />
Note:  I recommend changing the permalink from the default to: "/%category%/%postname%" on the Settings / Permalink page for friendlier looking WordPress and UnGallery URLs.
</p>

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
This is the directory UnGallery creates and writes cache files to.

<hr />

<h3>FancyBox</h3>

<p>
This section configures the very stylish fancyBox features created by Jānis Skarnelis.  UnGallery goes from being a handy way of efficiently publishing many images, to also delivering the look and feel of the most polished gallery plugins.  FancyBox Version 2x is licensed via Creative Commons, not GPL and therefor not included with UnGallery (to comply with WordPress.org policy).  FancyBox is free for personal and non-profit use and a small fee is charged for commercial use.  Please check <a href="http://sites.fastspring.com/fancyapps/product/store">here</a> for details.  The Creative Commons license details are <a href="http://creativecommons.org/licenses/by-nc/3.0/">here</a>. 
</p>
Setup is simple but I'll work to automate it in the future. <br />
<p><strong>Step 1:</strong><br />
Copy and paste the fancyBox calls into the WordPress header.  You can do this from the <a href="<?php print get_bloginfo('url')  ?>/wp-admin/theme-editor.php"> WordPress admin menu / Appearance / Editor </a> Navigate there or click the link and then the header.php link.  Insert the lines below between the &lt;head&gt; and &lt;/head&gt; tags.</p>

<pre>
&lt;!-- Add jQuery library and fancyBox--&gt;
&lt;script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"&gt;&lt;/script&gt;
&lt;link rel="stylesheet" href="./wp-content/plugins/fancybox/source/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" /&gt;
&lt;script type="text/javascript" src="./wp-content/plugins/fancybox/source/jquery.fancybox.pack.js?v=2.0.5"&gt;&lt;/script&gt;
&lt;link rel="stylesheet" href="./wp-content/plugins/fancybox/source/helpers/jquery.fancybox-buttons.css?v=2.0.5" type="text/css" media="screen" /&gt;
&lt;script type="text/javascript" src="./wp-content/plugins/fancybox/source/helpers/jquery.fancybox-buttons.js?v=2.0.5"&gt;&lt;/script&gt;
&lt;link rel="stylesheet" href="./wp-content/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" /&gt;
&lt;script type="text/javascript" src="./wp-content/plugins/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.5"&gt;&lt;/script&gt;
</pre>

<p><strong>Step 2:</strong> <br />
Download fancyBox and unzip the directory to the same level (./wp-content/plugins/) as your other plugins:  ./wp-content/plugins/fancybox/.  It's available here: <a href="https://github.com/fancyapps/fancyBox/zipball/v2.0.5">fancyBox v. 2.0.5</a>. You can type or paste the following lines:<br />
<pre>
	cd ./wp-content/plugins/
	wget https://github.com/fancyapps/fancyBox/zipball/v2.0.5
	unzip v2.0.5
	mv fancyapps-fancyBox-5403ca0 fancybox
</pre>
The new fancyBox directory should be here: <input type="text" readonly value="<?php print $_SERVER['DOCUMENT_ROOT']."/wp-content/fancybox/"; ?>" size="70"> <br />
<p><strong>Step 3:</strong> Activate fancyBox<br />
<input name="activate_fancybox" id="activate_fancybox" value="true" type="checkbox" <?php if ( get_option('activate_fancybox') == 'true' ) echo ' checked="checked" '; ?> /> <?php _e('Toggle this checkbox to activate or deactivate fancyBox.'); ?>
</p>

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
<p><?php _e("Number of thumbnail columns:", 'columns' ); ?> 
<input type="text" name="<?php echo $columns_data_field_name; ?>" value="<?php echo $columns_val; ?>" size="10">
Default: 3
</p>

<p><?php _e("Thumbnail width in pixels:", 'thumbnail' ); ?> 
<input type="text" name="<?php echo $thumbnail_data_field_name; ?>" value="<?php echo $thumbnail_val; ?>" size="10">
Default: 190
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

<p><?php _e("Name used for hidden galleries:", 'hidden' ); ?> 
<input type="text" name="<?php echo $hidden_data_field_name; ?>" value="<?php echo $hidden_val; ?>" size="20">
Example: hidden
</p>

<p>Do not display the zip archive link: <input name="disable_zip" id="disable_zip" value="true" type="checkbox" <?php if ( get_option('disable_zip') == 'true' ) echo ' checked="checked" '; ?> /> <br />
<?php _e('Check this box to remove the zip link from all pages.'); ?>
</p>

<p>A single gallery can contain an unlimited number of images and sub-galleries organized using the file system directory tree.  <br />
If you'd like to publish separate galleries, each with its own WordPress page, use the following fields to configure.<br />
<br />
<?php _e("2nd gallery permalink:", 'gallery2' ); ?> 
<input type="text" name="<?php echo $gallery2_data_field_name; ?>" value="<?php echo $gallery2_val; ?>" size="20">&nbsp;&nbsp;&nbsp;&nbsp;
<?php _e("Path to 2nd gallery image directory:", 'images2_path' ); ?> 
<input type="text" name="<?php echo $path2_data_field_name; ?>" value="<?php echo $path2_val; ?>" size="30">
</p>

<p><?php _e("3rd gallery permalink:", 'gallery3' ); ?> 
<input type="text" name="<?php echo $gallery3_data_field_name; ?>" value="<?php echo $gallery3_val; ?>" size="20">&nbsp;&nbsp;&nbsp;&nbsp;
<?php _e("Path to 3rd gallery image directory:", 'images3_path' ); ?> 
<input type="text" name="<?php echo $path3_data_field_name; ?>" value="<?php echo $path3_val; ?>" size="30">
</p>

<p><?php _e("4th gallery permalink:", 'gallery4' ); ?> 
<input type="text" name="<?php echo $gallery4_data_field_name; ?>" value="<?php echo $gallery4_val; ?>" size="20">&nbsp;&nbsp;&nbsp;&nbsp;
<?php _e("Path to 4th gallery image directory:", 'images4_path' ); ?> 
<input type="text" name="<?php echo $path4_data_field_name; ?>" value="<?php echo $path4_val; ?>" size="30">
</p>

<p><?php _e("5th gallery permalink:", 'gallery5' ); ?> 
<input type="text" name="<?php echo $gallery5_data_field_name; ?>" value="<?php echo $gallery5_val; ?>" size="20">&nbsp;&nbsp;&nbsp;&nbsp;
<?php _e("Path to 5th gallery image directory:", 'images5_path' ); ?> 
<input type="text" name="<?php echo $path5_data_field_name; ?>" value="<?php echo $path5_val; ?>" size="30">
</p>

<p><?php _e("6th gallery permalink:", 'gallery6' ); ?> 
<input type="text" name="<?php echo $gallery6_data_field_name; ?>" value="<?php echo $gallery6_val; ?>" size="20">&nbsp;&nbsp;&nbsp;&nbsp;
<?php _e("Path to 6th gallery image directory:", 'images6_path' ); ?> 
<input type="text" name="<?php echo $path6_data_field_name; ?>" value="<?php echo $path6_val; ?>" size="30">
</p>

<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>
</div>

<?php
 
}

?>