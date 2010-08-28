<?php
/*
Plugin Name: UnGallery
Plugin URI: http://markpreynolds.com/technology/wordpress-ungallery
Version: 0.9.4
Author: Mark Reynolds
Description: Displays directories of photos as a browsable WordPress gallery.
*/


function ungallery() {
	$blogURI = get_bloginfo('url') . "/";	
	$dir = "wp-content/plugins/ungallery/";
	$pic_root = $dir."pics/";
	$hidden = file_get_contents($dir."hidden.txt");
	$gallery = $_GET['gallerylink'];
	$src = $_GET['src'];
	if(function_exists('exif_read_data')) $rotatable = "jpeg_rotate.php";
		else $rotatable = "thumb.php";
	
//	This section sets the size and layout of the gallery.  The default dimensions are to fit the page size
//	WordPress ships with.  You may want to use larger pictures and a wider page.  If you increase page width
//	or use a theme like like Atahualpa, you can increase the defaults as suggested below in the comments. 
//	For example the commented dimensions fit page width 1150px, which I use at MarkPReynolds.com.
	
//$marquee = "yes";	//	To display a single picture, large at the top of your gallery tree, uncomment this line.
$thumbW = 135;		//	175		This sets thumbnail size.  					
$srcW = 475;		//	650		This sets browsed-to and top level marquee (if set) picture size.  			
$columns = 4;		//	5		This sets the number of thumbnail columns.	
$w = $thumbW;

	
	if (isset($src)) {		 				//	If we are browsing a gallery, get the gallery name from the src url
		$lastslash =  strrpos($src, "/");	// 	Trim the filename off the end of the src link
		$gallery =  substr($src, 5, $lastslash - 5 );   
	}
	//  consider ".." in path an attempt to read dirs outside gallery, so redirect to gallery root
	if (strstr($gallery, "..")) $gallery = "";

	if ($gallery == "") {
		$gallery =  "";
	} else {   	//  If $gallerylink is set and not "" then....
	
		//  Build the full gallery path into an array
		$gallerypath =  explode("/", $gallery);
	
		//  Render the Up/Current directory links
		print '<a href="./gallery">Top</a>';
		foreach ($gallerypath as $key => $level) {
			$parentpath = $parentpath . $level ;
			print ' / <a href="gallery?gallerylink='. $parentpath .'" >'. $level .'</a>';
			$parentpath = $parentpath . "/";
		}
	}

										// Create the arrays with the dir's media files
	$dp = opendir($pic_root.$gallery);
	while ($filename = readdir($dp)) {
		if (!is_dir($pic_root.$gallery. "/". $filename))  {  // If it's a file, begin
				$pic_types = array("JPG", "jpg", "GIF", "gif", "PNG", "png"); 		
				if (in_array(substr($filename, -3), $pic_types)) $pic_array[] = $filename;		// If it's a picture, add it to thumb array
				else {
					$movie_types = array("MP4", "mp4");								
					if (in_array(substr($filename, -3), $movie_types)) $movie_array[$filename] = size_readable(filesize($pic_root.$gallery. "/". $filename));		// If it's a movie, add name and size to the movie array
				}
		}
	} 
	// If we are viewing a gallery, arrange the thumbs
	if($pic_array) sort($pic_array);	
	// Unless we are at the top level and marquee is set, display the zip link
	if ($_SERVER["REQUEST_URI"]  !== "/gallery") print '  / <a href="'. $blogURI .'/gallery?zip=' . $gallery . '" title="Download a zipped archive of all photos in this gallery">-zip-</a> /';	
	elseif ($marquee !== "yes") print '  / <a href="'. $blogURI .'/gallery?zip=' . $gallery . '" title="Download a zipped archive of all photos in this gallery">-zip-</a> /';	

	// If this gallery is a hidden gallery, display a link to a list of all hidden galleries
	if (substr($_SERVER["REQUEST_URI"], -7)  == $hidden) print ' <a href="./gallery?hidden" title="View all '. $hidden .' galleries">-All '. $hidden .' -</a> /';	

	// Display the movie links
	if($movie_array) {					
		print ' <br>Movies:&nbsp;&nbsp;';
		foreach ($movie_array as $filename => $filesize) {
			print  '
				<a href="gallery?src=pics/'. substr($parentpath, 0, strlen($parentpath) -1).$subdir.'/'.$filename. '" title="This movie file size is '. $filesize .'">'	.$filename.'</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
		}
	}
	closedir($dp);
	print '&nbsp;&nbsp;&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;Sub Galleries&nbsp;:&nbsp;&nbsp;';

	$dp = opendir($pic_root.$gallery);	//  Display the Subdirectory links
	while ($subdir = readdir($dp)) {	//  If it is a subdir and not set as hidden, enter it into the array
		if (is_dir($pic_root.$gallery. "/". $subdir) && $subdir !="thumb_cache" && $subdir != "." && $subdir != ".." && !strstr($subdir, $hidden)) {
			$subdirs[] = $subdir;
		}
	}
	if($subdirs) {						//  List each subdir and link
		sort($subdirs);	
		foreach ($subdirs as $key => $subdir) {
			print  '<a href="gallery?gallerylink='. $parentpath.$subdir. '" >'	.$subdir.'</a> / ';
		}
	}
	closedir($dp);
	print '
	<table width="100%"><tr>';			//	Begin the table
	if (!isset($src) && isset($pic_array)) {							//	If we are not in browse view,
		if ($marquee == "yes" && $gallery == "") $w = $srcW;			//	Set size of marquee picture
			else $w = $thumbW;
		print '<div class="post-headline"><h2>'; 
		if (file_exists($pic_root.$gallery."/banner.txt")) {
			include ($pic_root.$gallery."/banner.txt");					//	We also display the caption from banner.txt
		} else {
			$lastslash =  strrpos($gallery, "/");
			if (strpos($gallery, "/")) print substr($gallery, $lastslash + 1);
			else print $gallery;
		}
		print "</h2></td></tr><tr>";									//	Close cell. Add a bit of space
		$column = 0;
		print '<td>';
		foreach ($pic_array as $filename) {								//  Use the pic_array to assign the links and img src
			if(stristr($filename, ".JPG")) {
				print '<a href="?src=pics/'.$gallery. "/" .$filename.'"><img src="'. $blogURI . $dir . $rotatable . '?src=pics/'.$gallery. "/". $filename.'&w=' .$w. '"></a>'; 				//  If it is a jpeg include the exif rotation logic
		   	} else {
				print '<a href="?src=pics/'.$gallery. "/" .$filename.'"><img src="'. $blogURI . $dir .'thumb.php?src=pics/'.$gallery. "/". $filename.'&w=' .$w. '"></a>';    
			}
			$column++;
			if ( $column == $columns ) {
				print '<br>';
				$column = 0;
			}
		}
	} else {														//  Render the browsing version, link to original, last/next picture, and link to parent gallery
	if (isset($src) && !in_array(substr($src, -3), $movie_types)) { //  If we are in broswing mode and the source is not a movie
		if (!strstr($src, "pics/")) die;     						//  If "pics" is not in path it may be an attempt to read files outside gallery, so redirect to gallery root
		$filename = substr($src, $lastslash + 1);
		$before_filename = $pic_array[array_search($filename, $pic_array) - 1 ];
		$after_filename = $pic_array[array_search($filename, $pic_array) + 1 ];
																	//  Display the current/websize pic
																	//  If it is a jpeg include the exif rotation logic
		if(stristr($src, ".JPG")) print '
		<td rowspan="2" style="vertical-align:middle;"><a href="'. $blogURI . $dir .'source.php?pic=' . $src . '"><img src="'. $blogURI . $dir . $rotatable . '?src='. $src. '&w='. $srcW. '"></a></td>
		<td>';
			else print '
			<td rowspan=2><a href="'. $blogURI . $dir .'source.php?pic=' . $src . '"><img src="'. $blogURI . $dir .'thumb.php?src='. $src. '&w='. $srcW. '"></a></td>
			<td valign="center">';

		if ($before_filename) {										// Display the before thumb, if it exists
																	//  If it is a jpeg include the exif rotation logic
			if(stristr($before_filename, ".JPG")) print '<a href="?src=pics/' . $gallery."/".$before_filename .'" title="Previous Gallery Picture"><img src="'. $blogURI . $dir . $rotatable . '?src=pics/' .$gallery."/".$before_filename .'&w='. $w .'"></a>';
			else print '<a href="?src=pics/' . $gallery."/".$before_filename .'" title="Previous Gallery Picture"><img src="'. $blogURI . $dir .'thumb.php?src=pics/' .$gallery."/".$before_filename .'&w='. $w .'"></a>';
		}
	print "</td>
	</tr>
	<tr>
	<td>
	";
		if ($after_filename) {										// Display the after thumb, if it exists
			if(stristr($after_filename, ".JPG")) print '	<a href="?src=pics/' . $gallery."/".$after_filename .'" title="Next Gallery Picture"><img src="'. $blogURI . $dir . $rotatable . '?src=pics/' .$gallery."/".$after_filename .'&w='. $w .'"></a>';		
			else print '	<a href="?src=pics/' . $gallery."/".$after_filename .'" title="Next Gallery Picture"><img src="'. $blogURI . $dir .'thumb.php?src=pics/' .$gallery."/".$after_filename .'&w='. $w .'"></a>';
		}
	} elseif (($movie_array) && (in_array(substr($src, -3), $movie_types))) print '<td>
<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab" width="440" height="380" ><br />
<PARAM NAME="src" VALUE="wp-content/plugins/ungallery/source.php?movie='. $src  .'" ><br />
<PARAM NAME="controller" VALUE="true" ><br />
<EMBED SRC="wp-content/plugins/ungallery/source.php?movie='. $src  .'" TYPE="image/x-macpaint" PLUGINSPAGE="http://www.apple.com/quicktime/download" AUTOPLAY="true" width="440" height="380" ><br />
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

if (strpos($_SERVER["REQUEST_URI"], "gallery?zip")) {				// If the zip flag is active, display the archive information page and links
	add_filter('the_content', "zip");
}	elseif (strpos($_SERVER["REQUEST_URI"], "gallery?hidden")) {	// If the hidden flag is active, display the hidden links page
	add_filter('the_content', "hidden");	
}	elseif (strstr($_SERVER["REQUEST_URI"], "/gallery")) {	// Otherwise display the main gallery
	add_filter('the_content', "ungallery");
}

function zip() {
	$blogURI = get_bloginfo('url') . "/";	
	include ("zip.php");
}

function hidden() {
	include ("hidden.php");
}
?>