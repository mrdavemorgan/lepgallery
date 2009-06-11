=== UnGallery ===
Contributors: mmond
Tags: gallery
Requires at least: 
Tested up to: 2.7.1
Stable tag: trunk

Imports directories of pictures as a browsable WordPress gallery.  

== Description ==

UnGallery imports directories of pictures as a browsable WordPress gallery. 

The main value is zero management of the photo gallery within WordPress.  After installing the plugin, you upload, move, delete and edit the photo files directly.  UnGallery picks up the changes immediately.  If you've ever had to reorganize many of your pictures, or remove a few or edit the red-eye of a dozen, you know how inconvenient it can be to have to return to the gallery UI to keep it updated.  With UnGallery, any changes you make to your pictures or their organization are automatically current, on the next browser refresh.

This plugin is still young, so there will be things to fix.  Feel free to use it, extend it or contact me with questions.
Much of the script is taken from other published sources and noted inline.

Mark Reynolds http://markpreynolds.com

== Installation ==

1. Upload the ungallery directory to your /wp-content/plugins/ directory. 
1. Activate through the 'Plugins' menu in WordPress.
1. Enable Permalinks: Settings -> Permalinks -> Custom Structure -> /%category%/%postname%
1. Create a blank WordPress *Page* called "Gallery".
1. Picture files go in the /pics/ subdirectory included or you can point to your own picture directory tree.  See Notes below.

== Features ==

* Unlimited depth, breadth, and number of photos in library. Mine has approx 6,000.
* Photo library is managed outside of WordPress, simply update via FTP, SCP, etc.  UnGallery sees changes immediately.
* Set optional banner captions
* Hidden, private galleries
* Thumbnail cache files are added to photo directory for faster page loads
* Support for png, jpg, bmp, mov, avi, mp3, mp4
* Automatic image rotation of jpegs with exif orientation
* Gallery hierarchy breadcrumbs and with links to parent galleries and sub-galleries
* Multiple gallery views:  Top level intro, thumbnails, browsing previous and next pictures.

== Screenshots ==

1. The browsing view.  One picture is larger and thumbnails for the previous and next picture links are displayed.  There were movie files in this directory, so links to view those are displayed also.
2. The gallery thumbnail view.  A breadcrumb trail up to the top level of the gallery is displayed along with the sub-galleries.  These are each generated automatically by reading the file system of your photo directories.

== Dependencies ==

* PHP GD lib on server. This is mostly standard these days.
* Permalinks via Settings -> Permalinks -> Custom Structure -> /%category%/%postname%
  More info here: http://teamtutorials.com/web-development-tutorials/clean-url%E2%80%99s-with-wordpress 
* Write permission to the photo directories. UnGallery creates a "thumb_cache" to greatly improve performance. 


== Notes ==

* Create a symlink called "pics" to your picture directory (recommended) or copy/move/create your photo directory tree to /wp-content/plugins/ungallery/pics/ 
* To display a caption over a gallery, add a file named banner.txt to that directory with the desired text.
* The top level directory is intended to have a larger marquee picture displayed, so only only one picture file should be placed in the top directory.
* To mark a gallery hidden, edit the hidden.txt file. If the content of hidden.txt is: "hidden" for example then any directories you create named "hidden", will not be visible via gallery browsing.
* The symlinking to or placing a directory of photos, within the WordPress install directories could effect backups of the WordPress file system.  If you archive the wp-content/plugins directory, be aware your gallery photos will be added to that routine.  If this is not desirable, adjust the backup script to exclude wp-content/plugins/ungallery/pics/.  I'll make the target dir configurable later and skip the need to symlink or place the gallery directories there.
* If you'd like to modify the size of the large pic and the thumbnails displayed, edit ./ungallery/ungallery.php.  The place to do this is noted inline, near the top of the file.

== To do ==

* Make gallery directory target an admin page option
* Make thumbnail caching optional
* Allow URL's as gallery target
* Add sizing options to admin page
* Add caption creation to admin page
* Add hidden text to admin page

== Bugs ==

* Empty picture directory messes up table formatting
* Arriving at the gallery page via a WordPress search widget breaks url args

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


