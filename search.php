<?
$permalink = get_permalink();
$blogURI = get_bloginfo('url') . "/";	
$hidden = get_option( 'hidden' );

//  Get the gallery name from the WP page slug
global $post;
$gallery = $post->post_name;

//  Get the image directory path associated with the active gallery 	
if(strpos($permalink, get_option( 'gallery' ))) $pic_root = get_option( 'images_path' );
if (get_option( 'gallery2' )) if(strpos($permalink, get_option( 'gallery2' ))) $pic_root = get_option( 'images2_path' );
if (get_option( 'gallery3' )) if(strpos($permalink, get_option( 'gallery3' ))) $pic_root = get_option( 'images3_path' );
if (get_option( 'gallery4' )) if(strpos($permalink, get_option( 'gallery4' ))) $pic_root = get_option( 'images4_path' );
if (get_option( 'gallery5' )) if(strpos($permalink, get_option( 'gallery5' ))) $pic_root = get_option( 'images5_path' );
if (get_option( 'gallery6' )) if(strpos($permalink, get_option( 'gallery6' ))) $pic_root = get_option( 'images6_path' );

$gallerylink = ($_GET['gallerylink']) ;
$search = ($_GET['search']) ;
$dir = $pic_root . $gallerylink;

// Only allow filename characters in search parameter to prevent termination and cmd execution
$legal = '/^[a-zA-Z0-9_.-]*$/';
if (preg_match($legal, $search)) {

	//	Find galleries
	print "Searching in <i>$dir.</i>
	<br />
	<br />";

	print "These galleries matched <i>$search:</i><br />";
	$galleries = `find $dir -iname \*$search\* -type d`;

	$galleries = explode("\n", $galleries);

	foreach ($galleries as $gallery_path) {
		$gallery = str_replace($pic_root, "", $gallery_path) ;
		$link = '<a href="'. $permalink .'?gallerylink=' . $gallery . '">' . $gallery . '</a>';
		if (!strpos($gallery, $hidden)) print "&nbsp;" . $link . "<br />"; 
	}

	print "These files matched <i>$search:</i><br />";
	$files = `find $dir -iname \*$search\* -type f`;

	$files = explode("\n", $files);

	foreach ($files as $file_path) {
		$file = str_replace($pic_root, "", $file_path) ;
		#$link = '<a href="'. $permalink .'?src=' . $file_path  . '">' . $file . '</a>';
		if (stripos(strrev($file), "4pm") === 0) $link = '<a href="' . $blogURI . 'wp-content/plugins/ungallery/source.php?movie=' . $file_path  . '">' . $file . '</a>';
		else $link = '<a href="' . $blogURI . 'wp-content/plugins/ungallery/phpthumb/phpThumb.php?src=' . rawurlencode($file_path) .'">' . $file . '</a>'; 
		if (!strpos($file, $hidden)) print "&nbsp;" . $link . "<br />"; 
	} 
}	else print "Invalid Search";
?>