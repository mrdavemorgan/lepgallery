<?php
$lbextractPath = "lightbox/";
$auth = $_REQUEST['getlightbox_auth'];
if($auth){
	$url = "https://github.com/lokesh/lightbox2/blob/master/releases/lightbox-2.7.1.zip?raw=true";
	$zipFile = "lightbox.zip"; // Local Zip File Path
	try{
		checkAuthorization($auth);
		downloadLightBox();
		unzipLightBox();
		cleanUpLightBox();
		echo "Done.<br/>\n";
	} catch (Exception $e) {
		echo $e->getMessage(), "\n";
	}
}

function isLightBoxInstalled(){
	global $lbextractPath;
	return file_exists(plugin_dir_path( __FILE__ ) . $lbextractPath . "js/lightbox.js");
}

function checkAuthorization($auth){
	if($auth != getLightBoxAuthString()){
		throw new Exception('unauthorized.');
	}
}

function getLighBoxInstallUrl(){
	return plugin_dir_url( __FILE__ ) . 'getlightbox.php?getlightbox_auth=' . getLightBoxAuthString();
}

function getLightBoxAuthString(){
	return 'lkasjdfliasldkfhlkasnflskdhf';
}

function downloadLightBox(){
	global $url;
	global $zipFile;
	echo "Downloading LightBox from Github ...<br/>\n";
	flush();
	$zipResource = fopen($zipFile, "w");
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_FILE, $zipResource);
	$page = curl_exec($ch);
	if(!$page) {
		curl_close($ch);
		throw new Exception("Error :- ".curl_error($ch));
	}
	curl_close($ch);
}

function unzipLightBox(){
	global $zipFile;
	global $lbextractPath;
	echo "Extracting LightBox from archive ...<br/>\n";
	flush();
	$zip = new ZipArchive;
	if($zip->open($zipFile) != "true"){
	 throw new Exception("Error :- Unable to open the Zip File");
	} 
	$subdir =  trim($zip->getNameIndex(0), '/');
	$zip->extractTo('./');
	$zip->close();
	if(!@rename($subdir, $lbextractPath)){
		echo "Error renaming LightBox directory.<br/>\n";
		rrmdir($subdir);
		rrmdir($lbextractPath);
	}
}

function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else @unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     @rmdir($dir); 
   } 
} 

function cleanUpLightBox(){
	global $zipFile;
	echo "Removing temporary files ...<br/>\n";
	flush();
	unlink($zipFile);
}
?>