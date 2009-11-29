<?
$hidden = file_get_contents("wp-content/plugins/ungallery/hidden.txt");
print '<strong>These directories are set to "'. $hidden .'" and not browsable.</strong><br><br>';
$home = "wp-content/plugins/ungallery/pics/";
hidden_search($home, $hidden);

function hidden_search($home, $hidden) {
	$dp = opendir($home);
	while ($dir = readdir($dp)) {
		if (is_dir($home.$dir) and $dir !== "." and $dir !== "..") {
			if($dir == $hidden) {
				print '<a href="./gallery?gallerylink='. substr($home.$dir, 34) .'">'. substr($home, 34) .'</a><br>';
			}
			hidden_search($home.$dir."/", $hidden);
		}
	}
}
?>