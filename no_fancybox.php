<?		//  Get the page name from the WP page slug
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
	$max_thumbs = get_option( 'max_thumbs' ); 
	if ($max_thumbs == 0) $max_thumbs = 25;
		
	//	Provide the version of UnGallery
	print "<!-- UnGallery version: ". $version ." -->";

	$w = $thumbW;
	$blogURI = get_bloginfo('url') . "/";	
	$dir = "wp-content/plugins/ungallery/";
	$gallerylink = $_GET['gallerylink'];
	$src = $_GET['src'];
	$movie_types = array();
	$page = $_GET['page'];

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
	if ($_SERVER["REQUEST_URI"]  !== "/".$gallery) print '  / <a href="'. $permalink . $QorA .'zip=' . $gallerylink . '" title="Download a zipped archive of all photos in this gallery">-zip-</a> / <form name="myform" action="'. $permalink . '" style="display: inline" > 
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
				<a href="./wp-content/plugins/ungallery/source.php?movie=' . $pic_root . substr($parentpath, 0, strlen($parentpath) -1).$subdir.'/'.$filename. '" title="This movie file size is '. $filesize .'">'	.$filename.'</a>&nbsp;&nbsp;/&nbsp;&nbsp;';
		}
	}
	closedir($dp);

	$dp = opendir($pic_root.$gallerylink);	//  Read the directory for subdirectories
	while ($subdir = readdir($dp)) {		//  If it is a subdir and not set as hidden, enter it into the array
		if (is_dir($pic_root.$gallerylink. "/". $subdir) && $subdir != "." && $subdir != ".." && !strstr($subdir, $hidden)) {
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
		// Handle maximum thumbs per page 
		$sliced_array = $pic_array;
		if ($max_thumbs < count($pic_array)) {		// If we are displaying thumbnails across multiple pages, update array with page data
			if($page) {
				$page = substr($page, 1) ;	// Remove p from page string
				$offset = ($page -1) * $max_thumbs;
			}
			$sliced_array = array_slice($pic_array, $offset, $max_thumbs);
		}
		foreach ($sliced_array as $filename) {						//  Use the pic_array to display the thumbs and assign the links
			print '<a href="' . $permalink . $QorA . 'src='. $pic_root . $gallerylink. "/" .$filename.'"><img src="'. $blogURI . $dir . 'phpthumb/phpThumb.php?ar=x&src='. $pic_root . $gallerylink. "/". $filename.'&w=' .$w. '"></a>'; 
			$column++;
			if ( $column == $columns ) {
				print '<br>';
				$column = 0;
			}
		}
		// If we are displaying thumbnails across multiple pages, display Next/Previos page links
		if ($max_thumbs < count($pic_array)) {	
					
			$pages = ceil(count($pic_array) / $max_thumbs) ;	//	Get the number of pages	
			
			if (!$page) $page = 1;
			print "</tr><tr><td>";
			if ($page > 1) 	{
				$previous = $page - 1;
				print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page=p'. $previous .'">Previous Page</a>';
			}
			print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($pages > $page) {
				$next = $page + 1;
				print '<a href="'. $permalink . $QorA .'gallerylink='. $gallerylink . '&page=p'. $next .'">Next Page</a>';
			}
			print  "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - This gallery has $pages pages -";
		}
		
		// Complete the table formatting 
		print "	</td></tr>
	</td>
	</table>";
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
	// Complete the table formatting 
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
?>