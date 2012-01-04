<?php
/*
Plugin Name: UnGallery
Description: Publish thousands of pictures in WordPress, in minutes.    
Plugin URI: http://markpreynolds.com/technology/wordpress-ungallery
Author: Mark Reynolds
Author URI: http://markpreynolds.com/professional
Author Email: mark@markpreynolds.com
Version: 1.7.1
*/

//  Set plugin version, update database so admin menu can display it
$version_val = "1.7.1";
update_option( "version", $version_val );

//  Display the plugin administration menu
include("configuration_menu.php");

//  Get the gallery names from the database
$gallery = get_option( 'gallery' );
$gallery2 = get_option( 'gallery2' );
$gallery3 = get_option( 'gallery3' );
$gallery4 = get_option( 'gallery4' );
$gallery5 = get_option( 'gallery5' );
$gallery6 = get_option( 'gallery6' );

//  If a gallery is not set in db, give it a value besides "" so not to trigger plugin
if($gallery == "") $gallery = "UnGalleryWontLoad"; 
if($gallery2 == "") $gallery2 = "UnGalleryWontLoad"; 
if($gallery3 == "") $gallery3 = "UnGalleryWontLoad"; 
if($gallery4 == "") $gallery4 = "UnGalleryWontLoad";
if($gallery5 == "") $gallery5 = "UnGalleryWontLoad";
if($gallery6 == "") $gallery6 = "UnGalleryWontLoad";

// If the search flag is active, display the search page
if (strpos($_SERVER["REQUEST_URI"], "&search=")) add_filter('the_content', "search"); 

// If the zip flag is active, display the archive page
elseif (strpos($_SERVER["REQUEST_URI"], "?zip")) add_filter('the_content', "zip"); 

// If any gallery flags are active, run the display gallery code
elseif (strstr($_SERVER["REQUEST_URI"], "/". $gallery) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery2)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery3)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery4)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery5)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery6))) {			
	add_filter('the_content', "ungallery");
}

function ungallery() {
	
	//  Get the page name from the WP page slug
	global $wp_query;
	$post_obj = $wp_query->get_queried_object();
	$post_ID = $post_obj->ID;
	$post_name = $post_obj->post_name;
	
	//  Get the current gallery page's permalink
	$permalink = get_permalink();
	
	//  Base the UnGallery linking format on the site's permalink settings
	if (strstr($permalink, "?")) {
		$QorA = "&";
		$gallery_ID = "?page_id=" . $post_ID;
	}
	 else {
		$QorA = "?";
		$gallery_ID = $post_name;
	}

	//  Get the image directory path associated with the gallery 	
	if($gallery_ID == get_option( 'gallery' )) $pic_root = get_option( 'images_path' );
	if($gallery_ID == get_option( 'gallery2' )) $pic_root = get_option( 'images2_path' );
	if($gallery_ID == get_option( 'gallery3' )) $pic_root = get_option( 'images3_path' );
	if($gallery_ID == get_option( 'gallery4' )) $pic_root = get_option( 'images4_path' );
	if($gallery_ID == get_option( 'gallery5' )) $pic_root = get_option( 'images5_path' );
	if($gallery_ID == get_option( 'gallery6' )) $pic_root = get_option( 'images6_path' );
	
	//	Load the configuration data from the database
	$version = get_option( 'version' );
	$hidden = get_option( 'hidden' );
	$marquee = get_option( 'marquee' );
	$marquee_size = get_option( 'marquee_size' );
	$thumbW = get_option( 'thumbnail' );
	$srcW = get_option( 'browse_view' );
	$movie_height = get_option( 'movie_height' );
	$movie_width = get_option( 'movie_width' );
	$columns = get_option( 'columns' );
	if($columns == "") $columns = 4; // set a default so admin page does not need visit after update. Remove at some point.
		
	//	Provide the version of UnGallery
	print "<!-- UnGallery version: ". $version ." -->";

	$w = $thumbW;
	$blogURI = get_bloginfo('url') . "/";	
	$dir = "wp-content/plugins/ungallery/";
	$gallerylink = $_GET['gallerylink'];
	$src = $_GET['src'];
	$movie_types = array();

	//	If we are browsing a gallery, gallerylink is not set so derive it from src in URL
	if (isset($src)) {
		$lastslash =  strrpos($src, "/");	
		$gallerylink = substr($src, strlen($pic_root));		// 	Trim the path off root and above
		$length = strrpos($gallerylink, "/"); 		// 	Find length of gallery in string
		$gallerylink = substr($gallerylink, 0, $length);	// 	Trim the filename off the end
	}

	if ($gallerylink == "") {
		$gallerylink =  "";
	} else {   	//  If ?gallerylink is set and not "" then....
	
		//  Build the full gallery path into an array
		$gallerylinkarray =  explode("/", $gallerylink);
	
		//  Render the Up/Current directory links
		print '<a href="'. $permalink .'">Top</a>';
		foreach ($gallerylinkarray as $key => $level) {
			$parentpath = $parentpath . $level ;
			print ' / <a href="'. $permalink . $QorA .'gallerylink='. $parentpath .'" >'. $level .'</a>';
			$parentpath = $parentpath . "/";
		}
	}

	// Create the arrays with the dir's media files
	$dp = opendir( $pic_root.$gallerylink);
	while ($filename = readdir($dp)) {
		if (!is_dir($pic_root.$gallerylink. "/". $filename))  {  // If it's a file, begin
				$pic_types = array("JPG", "jpg", "GIF", "gif", "PNG", "png", "BMP", "bmp"); 		
				if (in_array(substr($filename, -3), $pic_types)) $pic_array[] = $filename;		// If it's a picture, add it to thumb array
				else {
					$movie_types = array("MP4", "mp4");								
					if (in_array(substr($filename, -3), $movie_types)) $movie_array[$filename] = size_readable(filesize($pic_root.$gallerylink. "/". $filename));		// If it's a movie, add name and size to the movie array
				}
		}
	} 
	// If we are viewing a gallery, arrange the thumbs
	if($pic_array) sort($pic_array);	
	// Unless we are at the top level or the marquee is set, display the zip link and search form
	if ($_SERVER["REQUEST_URI"]  !== "/".$gallery) print '  / <a href="'. $permalink . $QorA .'zip=' . $gallerylink . '" title="Download a zipped archive of all photos in this gallery">-zip-</a> / <form name="myform" action="http://markpreynolds.com/gallery" style="display: inline" > 
	<input type="hidden" name="gallerylink" value="' . $gallerylink . '">
	<a href="javascript: submitform()">-search-</a> <input type="text" name="search" size="8"/>
	</form>
	<script type="text/javascript">
	function submitform()
	{
	  document.myform.submit();
	}
	</script>';	
	elseif ($marquee !== "yes") print '  / <a href="'. $permalink . $QorA .'zip=' . $gallerylink . '" title="Download a zipped archive of all photos in this gallery">-zip-</a> / ';	

	// Display the movie links
	if($movie_array) {					
		print ' <br>Movies:&nbsp;&nbsp;';
		foreach ($movie_array as $filename => $filesize) {
			print  '
				<a href="'. $permalink . $QorA .'src='. $pic_root . substr($parentpath, 0, strlen($parentpath) -1).$subdir.'/'.$filename. '" title="This movie file size is '. $filesize .'">'	.$filename.'</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
		}
	}
	closedir($dp);

	$dp = opendir($pic_root.$gallerylink);	//  Read the directory for subdirectories
	while ($subdir = readdir($dp)) {		//  If it is a subdir and not set as hidden, enter it into the array
		if (is_dir($pic_root.$gallerylink. "/". $subdir) && $subdir !="thumb_cache" && $subdir != "." && $subdir != ".." && !strstr($subdir, $hidden)) {
			$subdirs[] = $subdir;
		}
	}

	if($subdirs) {							//  List each subdir and link
		print '&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;Sub Galleries&nbsp;:&nbsp;&nbsp;';
		sort($subdirs);	
		foreach ($subdirs as $key => $subdir) {
			print  '<a href="'. $permalink . $QorA .'gallerylink='. $parentpath.$subdir. '" >'	.$subdir.'</a> / ';
		}
	}
	closedir($dp);
	print '
		<table width="100%"><tr>';			//	Begin the table
		if (!isset($src) && isset($pic_array)) {							//	If we are not in browse view,
			if ($marquee == "yes" && $gallerylink == "") $w = $marquee_size	;			//	Set size of marquee picture
				else $w = $thumbW;
			print '<td align="center"><div class="post-headline"><p style="text-align: center;">'; 
			if (file_exists($pic_root.$gallerylink."/banner.txt")) {
				include ($pic_root.$gallerylink."/banner.txt");					//	We also display the caption from banner.txt
			} else {
				$lastslash =  strrpos($gallerylink, "/");
				if (strpos($gallerylink, "/")) print "<h2>" . substr($gallerylink, $lastslash + 1) ."</h2>";
				else print "<h2>" . $gallerylink . "</h2>";
			}
			print "</td></tr><tr>";									//	Close cell. Add a bit of space
			print '<td align="center"><p style="text-align: center;">';
		$column = 0;
		foreach ($pic_array as $filename) {						//  Use the pic_array to display the thumbs and assign the links
			print '<a href="' . $permalink . $QorA . 'src='. $pic_root . $gallerylink. "/" .$filename.'"><img src="'. $blogURI . $dir . 'phpthumb/phpThumb.php?ar=x&src='. $pic_root . $gallerylink. "/". $filename.'&w=' .$w. '"></a>'; 
			$column++;
			if ( $column == $columns ) {
				print '<br>';
				$column = 0;
			}
		}
	} else {	//  Render the browsing version, link to original, last/next picture, and link to parent gallery
	if (isset($src) && !in_array(substr($src, -3), $movie_types)) { //  If we are in broswing mode and the source is not a movie
		$filename = substr($src, $lastslash + 1);
		$before_filename = $pic_array[array_search($filename, $pic_array) - 1 ];
		$after_filename = $pic_array[array_search($filename, $pic_array) + 1 ];
																	//  Display the current/websize pic
		print '
		<td align="center" rowspan="2" style="vertical-align:middle;"><a href="'. $blogURI . $dir .'phpthumb/phpThumb.php?src=' . $src . '"><img src="'. $blogURI . $dir . 'phpthumb/phpThumb.php?ar=x&src='. $src. '&w='. $srcW. '"></a></td>
		<td valign="center">';
			
		if ($before_filename) {										// Display the before thumb, if it exists
			print '<a href="'. $permalink . $QorA . 'src='. $pic_root . $gallerylink."/".$before_filename .'" title="Previous Gallery Picture"><img src="'. $blogURI . $dir .'phpthumb/phpThumb.php?ar=x&src='. $pic_root . $gallerylink."/".$before_filename .'&w='. $w .'"></a>';
		}
	print "</td>
	</tr>
	<tr>
	<td>
	";
		if ($after_filename) {										// Display the after thumb, if it exists
			print '<a href="'. $permalink . $QorA . 'src='. $pic_root . $gallerylink."/".$after_filename .'" title="Next Gallery Picture"><img src="'. $blogURI . $dir .'phpthumb/phpThumb.php?ar=x&src='. $pic_root . $gallerylink."/".$after_filename .'&w='. $w .'"></a>';
		}
	} elseif (($movie_array) && (in_array(substr($src, -3), $movie_types))) print '<td>
<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab" width="'. $movie_width .'" height="'. $movie_height .'" ><br />
<PARAM NAME="src" VALUE="wp-content/plugins/ungallery/source.php?movie='. $src  .'" ><br />
<PARAM NAME="controller" VALUE="true" ><br />
<EMBED SRC="wp-content/plugins/ungallery/source.php?movie='. $src  .'" TYPE="image/x-macpaint" PLUGINSPAGE="http://www.apple.com/quicktime/download" AUTOPLAY="true" width="'. $movie_width .'" height="'. $movie_height .'" ><br />
</EMBED><br />
</OBJECT>';															// If the source is a movie, play it
	else print "<br><br>"; 
	}
	print "
	</td>
	</tr>
	</table>";
}

function size_readable ($size, $retstring = null) {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        if ($retstring === null) { $retstring = '%01.2f %s'; }
        $lastsizestring = end($sizes);
        foreach ($sizes as $sizestring) {
                if ($size < 1024) { break; }
                if ($sizestring != $lastsizestring) { $size /= 1024; }
        }
        if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
        return sprintf($retstring, $size, $sizestring);
}

function search() {
	include ("search.php");
}

function zip() {
	$blogURI = get_bloginfo('url') . "/";	
	include ("zip.php");
}

// Add settings link on plugin page
function plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=ungallerysettings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'plugin_settings_link' );

function ungallery_set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	if ($file == $plugin) {
		return array_merge( $links, array( 
			'<a href="http://wordpress.org/tags/ungallery">' . __('Support Forum') . '</a>',
			'<a href="http://wordpress.org/extend/plugins/ungallery/faq/">' . __('FAQ') . '</a>',
			'<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=L6GZ4FVE8YR2S" title="If you find the plugin useful, consider supporting!">' . __('Donate') . '</a>'
		));
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'ungallery_set_plugin_meta', 10, 2 );


?>