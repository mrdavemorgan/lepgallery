=== UnGallery ===
Contributors: mmond
Tags: gallery, ungallery, pictures, movies, mp4, jpg, png, galleries, photos, browse
Requires at least: 
Tested up to: 3.0
Stable tag: trunk

Publish external picture directories in WordPress.  

== Description ==

UnGallery displays directories of pictures as a browsable WordPress gallery. 

The advantage of UnGallery is there is there is no administration required in WordPress.  You just point the plugin to a directory of photos, even thousands of them organized into many subdirectories, and they are immediately viewable via an existing WordPress site.  Any uploads, deletions, or other changes you make to your photos and directories are automatically reflected in WordPress.

If you've ever had to manage your photos after publishing them, you know how inconvenient it is to return to a web tool to correct the new location, change the thumbnails, etc.   With UnGallery, you can move entire galleries, remove a dozen red-eyes, rename an event or individual picture and these changes are automatically live in WordPress.

Mark Reynolds http://markpreynolds.com

== Installation ==

1. Upload to /wp-content/plugins/ and activate on the Plugins menu in WordPress.
1. Enable Permalinks: Settings -> Permalinks -> Custom Structure -> /%category%/%postname%
1. Create a blank WordPress Page called "Gallery".
1. Create a directory or symlink called "pics" in plugins/ungallery/ to contain your pictures. 
1. WordPress running on a Windows server has limited support, due to the low percentage of installations (~ 5%).  After downloading, copy files from plugins/ungallery/windows/ to plugins/ungallery/.  (UnGallery v.8 is tested up to WordPress 2.8)

== Features ==

* Unlimited depth, breadth, and number of photos in library. My gallery has about 6,000 pictures and movies.
* Photos are managed outside of WordPress.  Simply update a picture directory and UnGallery sees changes immediately.
* Default and configurable gallery titles
* Hidden, private galleries
* Caching for faster page loads
* MP4 movies embedded and played within the WordPress site.
* Image rotation support for orientation of jpegs with exif data
* Gallery hierarchy breadcrumb links
* Multiple gallery views:  Top level marquee, thumbnails, browsing previous and next pictures.

== Screenshots ==

1. The UnGallery top level view.  A the highest level of the gallery, a single "Marquee" picture is displayed and the links to the subdirectories/subgalleries.
2. Selecting one of the subgallery links above displays the gallery thumbnail view of all JPGs, PNGs and GIFs in that directory.  A breadcrumb trail up to the top level of the galleries is displayed along with the subgalleries.  These are each generated automatically by reading the file system of your photo directories. The -zip- link provides a zip file of all photo originals in the current directory for convenient download.
3. Clicking on a thumbnail displays the browsing view.  One picture is larger and the previous and next picture thumbnail links are displayed.  There are movie files in this directory, so links to view them are displayed also.  UnGallery's sizes are adjustable to fill larger page widths as this site uses.

== Changelog ==

= 0.9 =
* MP4's are now embedded and integrated into the WP site frame.  Support for older movie formats is depricated.
* Current directory breadcrumb link added.  This allows returning to the thumbnail list from the web-size browse view.
* Compatibility for WP 3.0's default twentyten theme that broke UnGallery's browse view.

== Dependencies ==

* Permalinks enabled: Settings -> Permalinks -> Custom Structure -> /%category%/%postname% <br>
  More info here: http://teamtutorials.com/web-development-tutorials/clean-url%E2%80%99s-with-wordpress 
* Write permission to the photo directories. UnGallery creates a "thumb_cache" to improve performance. 

== Notes ==

* In: ./wp-content/plugins/ungallery/ either create a symlink called "pics" to your picture directory (recommended) or copy/move/create a directory called pics there.  Please note, if you back up your WordPress install, including your plugins directory, be aware your gallery may be included via the symlink.
* To display a caption over a gallery, add a file named banner.txt to that directory with the desired text.
* The top level directory is intended to have a larger, marquee picture displayed, so only one picture file should be placed in the "/pics/" directory. There is no limit on pictures in the subdirectories.
* To mark a gallery hidden, edit the /ungallery/hidden.txt file. If e.g., the content of hidden.txt is: "hidden", then any directories you create named "hidden", will not be visible via gallery browsing.  
* If you'd like to modify the size of the marquee pic, browsing pic or the thumbnails, please edit /ungallery/ungallery.php.  The options are noted near the top of the file.

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


