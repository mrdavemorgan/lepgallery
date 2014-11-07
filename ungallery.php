<?php
/*
Plugin Name: Lepgallery
Description: Publish large image libraries with hierarchy. Based on UnGallery by Mark Reynolds.
Plugin URI: http://lepidoptera.net
Author: Dave Morgan
Author URI: http://lepidoptera.net
Version: 2.2.2
*/

//  Set plugin version, update database so admin menu can display it
$version_val = "2.2.2";
update_option( "version", $version_val );

//  Display the plugin administration menu
include("configuration_menu.php");

add_filter('the_content', "lepgallery");

function lepgallery($content) {
	if(strpos( $content, "{lepgallery=") === false){
		print $content;
		return;
	}
	if(preg_match('/{lepgallery=(.+?)}/', $content, $matches)){
		$pic_root = $matches[1];
	} else {
		print "lepgallery error";
		return;
	}

	//  Get the page name from the WP page slug
	global $wp_query;
	global $breadcrumb_separator;
	$post_obj = $wp_query->get_queried_object();
	$post_ID = $post_obj->ID;
	$post_name = $post_obj->post_name;
	
	//  Get the current gallery page's permalink
	$permalink = get_permalink();
	
	//  Base the gallery linking format on the site's permalink settings
	if (strstr($permalink, "?")) {
		$QorA = "&";
	} else {
		$QorA = "?";
	}

	//	Load the configuration data from the database
	$version = get_option( 'version' );
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
	$page = $_GET['page'];
	if (!$page) {
		$page = 1;
	}
	$offset = ($page -1) * $max_thumbs;
	$endset = $page * $max_thumbs;
	$squarethumb = (get_option('thumb_square') === 'true');
	$breadcrumb_separator = get_option( 'breadcrumb_separator' );
	if ($breadcrumb_separator == "") {
		$breadcrumb_separator = " / ";
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

	$items = array();
	$dp = opendir($pic_root.$gallerylink);	//  Read the directory for subdirectories
	while ($subdir = readdir($dp)) {		//  If it is a subdir enter it into the array
		if (is_dir($pic_root.$gallerylink. "/". $subdir) && (substr($subdir,0,1) != ".")) {
			$items[] = makeItemElement("subdir", "", $gallerylink . "/" . $subdir, $pic_root);
		}
	}
	closedir($dp);

	$dp = opendir( $pic_root.$gallerylink);
	$pic_types = array("JPG", "jpg", "GIF", "gif", "PNG", "png", "BMP", "bmp"); 	
	while ($filename = readdir($dp)) {
		if ((!is_dir($pic_root.$gallerylink. "/". $filename))  && (in_array(pathinfo($filename, PATHINFO_EXTENSION), $pic_types))) { 
			$items[] = makeItemElement("image", "", $gallerylink . "/" . $filename, $pic_root);
		}
	}
	closedir($dp);
	$pages = ceil(count($items) / $max_thumbs) ;	//	Get the number of pages	

	// echo "<pre>\n";
	// echo "BREADCRUMBS\n";
	// var_dump($breadcrumbs);
	// echo "\n\n\n\nITEMS\n";
	// var_dump($items);	
	// echo "</pre>\n";















	// table setup
	?><div class="lepgallerytable"><?

	// print the breadcrumbs
	if(count($breadcrumbs)>1){
		print '<p id="lepgallery_breadcrumbs">';
		foreach ($breadcrumbs as $bc) {
			print $breadcrumb_separator . '<a href="'. $permalink . $QorA .'gallerylink='. $bc['gallerypath'] .'" >'. $bc['name'] .'</a>';
		}
		print "</p>";
	}

	// print title or banner
	$here = end($breadcrumbs);
	if($here['banner']){
		print '<p id="lepgallery_banner">';
		include($here['banner']);
		print "</p>";
	} else {
		print '<h2 id="lepgallery_banner">' . $here['name'] ."</h2>";
	}

	//	Close cell. Add a bit of space
	?><p id="lepgallery_grid"><? 


 	$column = 0;
	if($squarethumb){
		$forcedsize = $w;
	}

	// print subdirectories and images
	if(count($items)>0){
		for($i=$offset; ($i<count($items) && $i<$endset); $i++){
			if($items[$i]['type'] == 'image'){
				$thumburl = getThumbUrl($phpthumburl, $w, $squarethumb, $items[$i]['fullpath'], 0, false);
				$lightboxurl = getThumbUrl($phpthumburl, $srcW, 0, $items[$i]['fullpath'], $watermark, false);
				printLightBoxButton($items[$i]['name'], $thumburl, $lightboxurl, $forcedsize);
			} else {
				if(file_exists($items[$i]['thumb'])){
					$thumburl = getThumbUrl($phpthumburl, $w, $squarethumb, $items[$i]['thumb'], 0, true);
				}
				printSubdirButton($items[$i]['name'], $thumburl, $permalink . $QorA .'gallerylink='. rawurlencode($items[$i]['gallerypath']), $forcedsize);
			}
			if((++$column) % $columns == 0){
				print "<br/>";
			}
		}
	}
	
	// If we are displaying thumbnails across multiple pages, display Next/Previous page links
	if ($pages > 1) {	
		print '</p><p id="lepgallery_footer">';
		if ($page > 1) 	{
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page=1" class="lepgallery_chevron lepgallery_chevronleftdouble"></a>';
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page='. ($page - 1) .'" class="lepgallery_chevron lepgallery_chevronleft"></a>';
		}
		print  "<span class=\"lepgallery_pagecount\"> Page $page / $pages </span>";
		if ($pages > $page) {
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page='. ($page + 1) .'" class="lepgallery_chevron lepgallery_chevronright"></a>';
			print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page='. $pages .'" class="lepgallery_chevron lepgallery_chevronrightdouble"></a>';
		}
	}
	
	// Complete the table formatting 
	?></p></div>
	<script src="wp-content/plugins/ungallery/lightbox/js/lightbox.js"></script>
	<?

}

function makeItemElement($type, $name, $gallerypath, $galleryroot){
	$gallerypath = ltrim($gallerypath, '/');
	$ret = array(
	    'gallerypath' => $gallerypath,
	    'fullpath' => $galleryroot . $gallerypath,
	    'type' => $type
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

function getThumbUrl($phpthumburl, $width, $square, $imgpath, $watermark, $blur){
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
	} else if($blur){
		$ret .= "&fltr[]=blur|25";
	}
	return $ret;
}

function printLightBoxButton($title, $thumburl, $expandedurl, $forcedsize){
	if($forcedsize){
		?><a href="<?=$expandedurl;?>" data-lightbox="lightbox-set" data-title="<?=$title;?>"><img 
			style="width: <?=$forcedsize;?>px; height: <?=$forcedsize;?>px;" src="<?=$thumburl;?>" alt=""/></a><?
	} else {
		?><a href="<?=$expandedurl;?>" data-lightbox="lightbox-set" data-title="<?=$title;?>"><img src="<?=$thumburl;?>" alt=""/></a><?
	}
}

function printSubdirButton($title, $thumburl, $url, $forcedsize){
	if($forcedsize){
		?><a class="lepgallerydir" href="<?=$url;?>"><img 
		style="width: <?=$forcedsize;?>px; height: <?=$forcedsize;?>px;" src="<?=$thumburl;?>"/><span><?=$title;?></span></a><?
	} else {
		?><a class="lepgallerydir" href="<?=$url;?>"><img src="<?=$thumburl;?>"/><span><?=$title;?></span></a><?
	}
}

// Add settings link on plugin page
function plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=lepgallerysettings">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

function lepgallery_set_plugin_meta($links, $file) {
	// create link
	if ($file == plugin_basename(__FILE__)) {
		return array_merge( $links, array( 
			'<a href="http://wordpress.org/tags/lepgallery">' . __('Support Forum') . '</a>',
			'<a href="http://wordpress.org/extend/plugins/lepgallery/faq/">' . __('FAQ') . '</a>',
			'<a href="https://winadatewithrusschapman.com" title="Russ!">' . __('Get a Date') . '</a>'
		));
	}
	return $links;
}

function lepgallery_enqueue_style() {
	wp_enqueue_style( 'lepgallery-lightbox', '/wp-content/plugins/ungallery/lightbox/css/lightbox.css', false ); 
	wp_enqueue_style( 'lepgallery-style', '/wp-content/plugins/ungallery/style.css', false ); 
}

add_filter( 'plugin_row_meta', 'lepgallery_set_plugin_meta', 10, 2 );
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'plugin_settings_link' );
add_action( 'wp_enqueue_scripts', 'lepgallery_enqueue_style' );

?>