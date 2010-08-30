=== UnGallery ===
Contributors: mmond
Tags: gallery, ungallery, pictures, movies, mp4, jpg, png, galleries, photos, browse
Requires at least: 
Tested up to: 3.0
Stable tag: trunk

Publish external image directories as gallery in WordPress.  

== Description ==

UnGallery displays directories of pictures as a browsable WordPress gallery. 

The advantage of UnGallery is there is there is no administration required in WordPress.  You just point the plugin to a directory of photos, even thousands of them organized into many subdirectories, and they are immediately viewable via an existing WordPress site.  Any uploads, deletions, or other changes you make to your photos and directories are automatically reflected in WordPress.

If you've ever had to manage your photos after publishing them, you know how inconvenient it is to return to a web tool to correct the new location, change the thumbnails, etc.   With UnGallery, you can rearrange entire galleries, edit a dozen party pic red-eyes, rename an event or individual picture and any of these changes are automatically live in WordPress.

Mark Reynolds http://markpreynolds.com

== Installation ==

1. Upload to /wp-content/plugins/ and activate on the Plugins menu in WordPress.
1. Enable Permalinks: Settings -> Permalinks -> Custom Structure -> /%category%/%postname%
1. Create a blank WordPress Page called "Gallery" or see notes on customizing the gallery name.
1. Create a directory or symlink called "pics" in plugins/ungallery/ to contain your pictures. 
1. WordPress running on a Windows server has limited support.  After downloading, copy files from plugins/ungallery/windows/ to plugins/ungallery/.  (UnGallery v.8 is tested up to WordPress 2.8)

== Features ==

* Unlimited depth, breadth, and number of photos in library. My gallery has about 6,000 pictures and movies.
* Photos are managed outside of WordPress.  Simply update a picture directory and UnGallery sees changes immediately.
* Default and configurable gallery titles
* Hidden galleries
* Caching for faster page loads
* MP4 movies embedded and played within the WordPress site.
* Image rotation support for orientation of jpegs with exif data
* Gallery hierarchy breadcrumb links
* Multiple gallery views:  Top level marquee (optional), thumbnails, browsing previous and next pictures.

== Screenshots ==

1. The UnGallery top level "Marquee" view.  Optionally, the highest level of the gallery displays a single picture is displayed prominently as are the links to the subdirectories/subgalleries.  The top level gallery can be set to display this way or as thumbnails like the subdirectories.  Uncomment the marquee setting line near the top of ungallery.php to toggle this option.
2. Selecting one of the subgallery links above displays the gallery thumbnail view of all JPGs, PNGs and GIFs in that directory.  A breadcrumb trail up to the top level of the galleries is displayed along with the subgalleries.  These are each generated automatically by reading the file system of your photo directories. The -zip- link provides a zip file of all photo originals in the current directory for convenient download.
3. Clicking on a thumbnail displays the browsing view.  One picture is larger and the previous and next picture thumbnail links are displayed.  There are movie files in this directory, so links to view them are displayed also.  UnGallery's sizes are adjustable to fill larger page widths as this site uses.

== Changelog ==

= 0.9 =
* MP4's are now embedded and integrated into the WP site frame.  Support for older movie formats is depricated.
* Current directory breadcrumb link added.  This allows returning to the thumbnail list from the web-size browse view.
* Compatibility for WP 3.0's default twentyten theme that broke UnGallery's browse view.
= 0.9.1 =
* Added hardening code and replaced relative links with absolute links
= 0.9.2 =
* Added top-level gallery logic to toggle marquee and zip display behavior
* Added support for custom WordPress and Site addresses
= 0.9.3 =
* Fixed issue with IE downloading zip archives of images
= 0.9.4 =
* Fixed issue with some browsers not playing mp4
* Fixed case sensitivity problem with .mp4/MP4
* Fixed erroneously reporting plugin download needed for directories with no image files.
= 0.9.5 =
* You no longer need to call the gallery: "gallery".  Any name can be used.
* Fixed issue with extra character in hidden.txt causing mismatch

== Dependencies ==

* Permalinks enabled: Settings -> Permalinks -> Custom Structure -> /%category%/%postname% 
* Write permission to the photo directories. UnGallery creates a "thumb_cache" directory in each gallery to improve performance. 

== Notes ==

* In: ./wp-content/plugins/ungallery/ either create a symlink called "pics" to your picture directory (recommended) or copy/move/create a directory called pics there.  Please note, if you back up your WordPress install, including your plugins directory, be aware your gallery may be included via the symlink.
* To display a caption over a gallery, add a file named banner.txt to that directory with the desired text.  The file can include plain text or html. If no banner.txt is found, the name of the directory used.
* The top level directory is intended to have a larger, marquee picture displayed, so only one picture file should be placed in the "/pics/" directory. There is no limit on pictures in the subdirectories.  This can be enabled/disabled in by updating the settings section at the top of ungallery.php.
* To mark a gallery hidden, edit the /ungallery/hidden.txt file. If e.g., the content of hidden.txt is: "hidden", then any directories you create named "hidden", will not be visible via gallery browsing.  
* If you'd like to modify the size of the marquee picture, browsing picture or the thumbnails, please edit /ungallery/ungallery.php.  The options are noted near the top of the file.
* To customize the gallery name that appears in the URL, update the $gallery = "gallery"; at the top of ungallery.php and create a blank WordPress of the same name.

== License ==

The MIT License

	
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.


