<?
// 	Choose the URL argument being passed to source.php
//	Build the content type link based on file type
//	Exit if the URI request type is not image, movie, or zip
//	to block access to non-gallery files

$allowed = array( "zip", "mp4", "MP4");
	
if ($_GET['zip']) {
	$filename = $_GET['zip'];
	$extension = substr($filename, -3);
	if (in_array($extension, $allowed)) {
		$len = filesize($filename);
		$lastslash =  strrpos($filename, "/");
		$name =  substr($filename, $lastslash + 1);

		header("Content-type: application/x-zip-compressed;\r\n"); 
		header("Content-Length: $len;\r\n");
		header('Content-Disposition: attachment; filename="' . $name . '"');  // Create a download stream link
		readfile($filename);	
	}
}

if ($_GET['movie']) {
	$filename = $_GET['movie'];
	$extension = substr($filename, -3);
	if (in_array($extension, $allowed)) {
		$len = filesize($filename);
		$lastslash =  strrpos($filename, "/");
		$name =  substr($filename, $lastslash + 1);   

		header("Content-type: video/mp4;\r\n");
		header("Content-Length: $len;\r\n");
		header("Content-Transfer-Encoding: binary;\r\n");
		header('Content-Disposition: inline; filename="'.$name.'"');	//  Render the video inline.
		readfile($filename);
	}
}
?>