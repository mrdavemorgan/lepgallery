<?php
/*
Plugin Name: UnGallery
Description: Publish thousands of pictures in WordPress, in minutes.    
Plugin URI: http://markpreynolds.com/technology/wordpress-ungallery
Author: Mark Reynolds
Author URI: http://markpreynolds.com
Author Email: mark@markpreynolds.com
Version: 2.2.2
*/

//  Set plugin version, update database so admin menu can display it
$version_val = "2.2.2";
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

$breadcrumb_separator = get_option( 'breadcrumb_separator' );
if ($breadcrumb_separator == "") $breadcrumb_separator = " / ";

// If any gallery flags are active, run the display gallery code
if (strstr($_SERVER["REQUEST_URI"], "/". $gallery) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery2)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery3)) || 	(strstr($_SERVER["REQUEST_URI"], "/". $gallery4)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery5)) || (strstr($_SERVER["REQUEST_URI"], "/". $gallery6))) {			
	add_filter('the_content', "ungallery");
}

function makeItemElement($type, $name, $gallerypath, $galleryroot){
	$gallerypath = ltrim($gallerypath, '/');
	$ret = array(
	    'gallerypath' => $gallerypath,
	    'fullpath' => $galleryroot . $gallerypath,
	);
	if($name){
		$ret['name'] = $name;
	} else {
		$ret['name'] = array_pop(explode("/", $gallerypath));
	}
	if($type == "breadcrumb"){
		if (file_exists($ret['fullpath']."/banner.txt")) {
			$ret['banner'] = $ret['fullpath']."/banner.txt";
		}
		if (file_exists($ret['fullpath']."/title.txt")) {
			$ret['name'] = file_get_contents($ret['fullpath']."/title.txt");
		}
		// don't care about thumb for breadcrumb since it's not displayed here
	} else if($type == 'subdir'){
		$thumb = getFolderImageFile($ret['fullpath']);
		if(file_exists($thumb)){
			$ret['thumb'] = $thumb;
		}
		if (file_exists($ret['fullpath']."/title.txt")) {
			$ret['name'] = file_get_contents($ret['fullpath']."/title.txt");
		}
		// don't care about banner for subdir since it's not used here
	} else if($type == 'image'){
		if (file_exists($ret['fullpath'] . ".txt")) {
			$ret['name'] = htmlentities(file_get_contents($ret['fullpath'] . ".txt"),ENT_QUOTES);
		}
	}
	return $ret;
}

function ungallery() {
	//  Get the page name from the WP page slug
	global $wp_query;
	global $breadcrumb_separator;
	$post_obj = $wp_query->get_queried_object();
	$post_ID = $post_obj->ID;
	$post_name = $post_obj->post_name;
	
	//  Get the current gallery page's permalink
	$permalink = get_permalink();
	
	//  Base the UnGallery linking format on the site's permalink settings
	if (strstr($permalink, "?")) {
		$QorA = "&";
		$gallery_ID = "?page_id=" . $post_ID;
	} else {
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
	$thumbW = get_option( 'thumbnail' );
	$srcW = get_option( 'browse_view' );
	$columns = get_option( 'columns' );
	if($columns == "") {
		$columns = 4; // set a default so admin page does not need visit after update. Remove at some point.
	}
	$max_thumbs = get_option( 'max_thumbs' ); 
	if ($max_thumbs == 0) {
		$max_thumbs = 25;
	}

	$w = $thumbW;
	$blogURI = get_bloginfo('url') . "/";	
	$dir = "wp-content/plugins/ungallery/";
	$phpthumburl = $blogURI . $dir . 'phpthumb/phpThumb.php';
	$gallerylink = $_GET['gallerylink'];
	$src = $_GET['src'];
	$page = $_GET['page'];
	if (!$page) {
		$page = 1;
	}
	$offset = ($page -1) * $max_thumbs;
	$endset = $page * $max_thumbs;
	$squarethumb = (get_option('thumb_square') === 'true');
	$allowraw = (get_option('allow_raw') === 'true');
	
	//	If we are browsing a gallery, gallerylink is not set so derive it from src in URL
	if (isset($src)) {
		$lastslash =  strrpos($src, "/");	
		$gallerylink = substr($src, strlen($pic_root));		// 	Trim the path off root and above
		$length = strrpos($gallerylink, "/"); 		// 	Find length of gallery in string
		$gallerylink = substr($gallerylink, 0, $length);	// 	Trim the filename off the end
	}







	// populating our content arrays
	$breadcrumbs = array();
	$breadcrumbs[] = makeItemElement("breadcrumb", get_the_title(), "", $pic_root);
	if($gallerylink){
		$gallerylinkarray =  explode("/", $gallerylink);
		foreach ($gallerylinkarray as $level) {
			$pp .= $level ;
			$breadcrumbs[] = makeItemElement("breadcrumb", "", $pp, $pic_root);
			$pp .= "/";
		}
	}

	$subdirectories = array();
	$dp = opendir($pic_root.$gallerylink);	//  Read the directory for subdirectories
	while ($subdir = readdir($dp)) {		//  If it is a subdir and not set as hidden, enter it into the array
		if (is_dir($pic_root.$gallerylink. "/". $subdir) && $subdir != "." && $subdir != ".." && !strstr($subdir, $hidden)) {
			$subdirectories[] = makeItemElement("subdir", "", $gallerylink . "/" . $subdir, $pic_root);
		}
	}
	closedir($dp);


	$images = array();
	$dp = opendir( $pic_root.$gallerylink);
	$pic_types = array("JPG", "jpg", "GIF", "gif", "PNG", "png", "BMP", "bmp"); 	
	while ($filename = readdir($dp)) {
		if ((!is_dir($pic_root.$gallerylink. "/". $filename))  && (in_array(pathinfo($filename, PATHINFO_EXTENSION), $pic_types))) { 
			$images[] = makeItemElement("image", "", $gallerylink . "/" . $filename, $pic_root);
		}
	}
	closedir($dp);
	$pages = ceil(count($images) / $max_thumbs) ;	//	Get the number of pages	

	// echo "<pre>\n";
	// echo "BREADCRUMBS\n";
	// var_dump($breadcrumbs);
	// echo "\n\n\n\nSUBDIRS\n";
	// var_dump($subdirectories);
	// echo "\n\n\n\nIMAGES\n";
	// var_dump($images);	
	// echo "</pre>\n";





	// print the breadcrumbs
	if(count($breadcrumbs)>1){
		foreach ($breadcrumbs as $bc) {
			print $breadcrumb_separator . '<a href="'. $permalink . $QorA .'gallerylink='. $bc['gallerypath'] .'" >'. $bc['name'] .'</a>';
		}
	}




	?><table width="100%"><tr>
	<td align="center"><div class="post-headline"><?

	// print title or banner
	$here = end($breadcrumbs);
	if($here['banner']){
		include($here['banner']);
	} else {
		print "<h2 style=\"text-align: center;\">" . $here['name'] ."</h2>";
	}


	?></td></tr><tr>
	<td align="center"><p style="text-align: center;">
	<? //	Close cell. Add a bit of space



 	$column = 0;

	// print subdirectories
	if(count($subdirectories)>0){

		foreach ($subdirectories as $sd) {
			if(file_exists($sd['thumb'])){
				$thumburl = getThumbUrl($phpthumburl, $w, $squarethumb, $sd['thumb'], 0);
			}
			printSubdirButton($sd['name'], $thumburl, $permalink . $QorA .'gallerylink='. rawurlencode($sd['gallerypath']));
			if((++$column) % $columns == 0){
				print "<br/>";
			}
		}
	}

	// print images
	if(count($images)>0){
		for($i=$offset; ($i<count($images) && $i<$endset); $i++){
			$img = $images[$i];
			$thumburl = getThumbUrl($phpthumburl, $w, $squarethumb, $img['fullpath'], 0);
			$lightboxurl = getThumbUrl($phpthumburl, $srcW, 0, $img['fullpath'], $watermark);
			if( $allowraw ){
				printLightBoxButton($img['name'], $thumburl, $lightboxurl, $rawurl);
			} else {
				printLightBoxButton($img['name'], $thumburl, $lightboxurl, 0);
			}
			if((++$column) % $columns == 0){
				print "<br/>";
			}
		}
	}
	
	// If we are displaying thumbnails across multiple pages, display Next/Previos page links
	if ($pages > 1) {	
		print "</tr><tr><td>";
		if ($page > 1) 	{
			$previous = $page - 1;
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page=1">&lt;&lt;</a>&nbsp';
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page='. $previous .'">&lt;</a>';
		}
		print  " - Page $page / $pages - ";
		if ($pages > $page) {
			$next = $page + 1;
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page='. $next .'">&gt;</a>&nbsp;';
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page='. $pages .'">&gt;&gt;</a>';
		}
	}
	
	// Complete the table formatting 
	?></td></tr></td></table><?

}

function getFolderImageFile($folder){
	$imgfullpath = $folder . '/_folderimage';
	if(file_exists($imgfullpath)){
		return $imgfullpath;
	}

	$dp = opendir($folder);
	$pic_types = array("JPG", "jpg", "JPEG", "jpeg"); 
	while ($filename = readdir($dp)) {
		if(is_dir($folder. "/". $filename)){
		} else if (in_array(pathinfo($filename, PATHINFO_EXTENSION), $pic_types)){
			closedir($dp);
			return $folder. "/". $filename;
		}
	} 
	rewinddir($dp);
	while ($filename = readdir($dp)) {
		if((is_dir($folder. "/". $filename)) && (substr($filename,0,1) != '.')){
				$subdirimg =  getFolderImageFile($folder. "/". $filename);
				if($subdirimg){
					closedir($dp);
					return $subdirimg;
				}
		}
	} 
	closedir($dp);
	return '';
}

function getTitleString($imagepath, $default){
	if (file_exists("$imagepath.txt")) {
		return htmlentities(file_get_contents("$imagepath.txt"),ENT_QUOTES);
	}
	return $default;
}

function getThumbUrl($phpthumburl, $width, $square, $imgpath, $watermark){
	if($width > 0){
		$ret = "$phpthumburl?ar=x&w=$width&src=$imgpath";
		if($square){
			$ret .= "&zc=1&h=$width";
		}
	} else {
		$ret = "$phpthumburl?ar=x&src=$imgpath";
	}
	if($watermark){
		$ret .= "&fltr[]=wmi|$watermark|BL|100";
	}
	return $ret;
}

function printLightBoxButton($title, $thumburl, $expandedurl, $rawurl){
	if($rawurl){
		?><a class="fancybox-button" href="<?=$expandedurl;?>" data-lightbox="lightbox-set" data-title="<a href=<?=$rawurl;?>  title=Original><?=$title;?></a>"><img src="<?=$thumburl;?>" alt=""/></a><?
	} else {
		?><a class="fancybox-button" href="<?=$expandedurl;?>" data-lightbox="lightbox-set" data-title="<?=$title;?>"><img src="<?=$thumburl;?>" alt=""/></a><?
	}
}

function printSubdirButton($title, $thumburl, $url){
	?><a class="fancybox-button" style="position: relative;" href="<?=$url;?>"
	><img src="<?=$thumburl;?>" style="opacity: 0.75;"/><span 
		style="position: absolute; left: 10px; bottom: 0px; width: 100%; height: 100%; vertical-align: center; color: black;"><?=$title;?></span></a><?
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