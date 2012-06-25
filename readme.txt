=== UnGallery ===
Contributors: mmond
Tags: gallery, ungallery, pictures, movies, mp4, jpg, png, gallery, photos, browse, images, slideshow, lightbox
Requires at least: 
Tested up to: 3.3.1
Stable tag: 2.1.1

Publish thousands of pictures in WordPress, in minutes.  

== Description ==

UnGallery displays your directories of images as a browsable WordPress gallery. 

The advantage of UnGallery is there is there is no gallery management required in WordPress.  You just point the plugin to a directory  of photos and they are immediately viewable via an existing WordPress site.  Any uploads, deletions, or edits you make to your photos and directory organization are automatically reflected in WordPress.

If you've ever had to reorganize galleries after publishing, you know how inconvenient it is to return to a web tool to correct the paths, relink the thumbnails, update titles, etc.   With UnGallery, you can restructure entire galleries, edit a dozen party pic red-eyes, rename an event or remove individual photos and each of these changes is automatically live in WordPress.

[Introduction and installation screencast](http://markpreynolds.com/technology/wordpress-ungallery)

Mark Reynolds http://markpreynolds.com

== Installation ==

= Ungallery =
1. Download to ./wp-content/plugins/ and activate via the Plugins menu.
2. Create a blank WordPress Page, for example one called "Gallery".  (Optionally update permalinks format)
3. On the UnGallery admin page, enter the permalink from above and the path to your images. 

The UnGallery steps above are simple and the install is generally quick.  However because the plugin works outside the WordPress environment and communicates with the web server file system, there are sometimes challenges troubleshooting the install.  It helps to have a bit of familiarity with Linux commands and paths.  If you encounter any problems, feel free to leverage the support resources.  Several tips and tools to help you install are built into UnGallery's plugin settings page.

Introduction and Installation Screencast:

http://markpreynolds.com/UnGallery2.mp4

= FancyBox =

FancyBox is a very polished image lightbox application.  UnGallery has been updated to integrate with fancyBox, which changes the plugin from being an efficient way to manage a high volume of photos to also having the look and feel of the most professional WordPress galleries.  I highly recommend activating this feature.

There are just a few additional steps to use fancyBox.  They only need to be performed once.  Automatic updates to UnGallery will not require the steps below to be rerun.  Details are the UnGallery settings page.

1. Paste the fancyBox calls from the settings page.
2. Download and unzip fancyBox from the link provided.
3. Check the box to activate fancyBox.

== Features ==

* Unlimited depth, breadth, and number of photos in library. My gallery has ~24,000 pictures and movies.
* Photos are managed outside of WordPress.  Simply update a picture directory and UnGallery sees changes immediately.
* Galleries are searchable.  This became very helpful as gallery volume grew to thousands.
* Default and configurable gallery titles
* Galleries can be set to hidden.  These do not display in browsing, with access provided via direct link.
* Caching for faster page loads
* MP4 movies browsable within WordPress. Movies are linked and playable within browser.
* Image rotation support for orientation of jpegs with exif data
* Gallery hierarchy breadcrumb links
* Multiple gallery views, thumbnails, browsing navigation buttons, and slideshow.

== Screenshots ==

1. The gallery browsing view with fancyBox lightbox application featuring thumbnails, navigation buttons, zoom, and slideshow.
2. Thumbnails are displayed during lightbox browsing.
3. Navigation is available via buttons or arrow keys.
4. The UnGallery default view with subdirectories/subgalleries, breadcrumbs, zip, and search available.

== Frequently Asked Questions ==

= What do I have to set up? =
1. Download and activate the plugin.
1. Create a blank WordPress page.
1. On the UnGallery settings menu enter page name and path to images.

That's it.  You can install UnGallery and publish a thousand photos to your WordPress site in just a few minutes. While the default configuration is simple, there are many customizable options available in the advanced options of UnGallery, including layout, gallery names, hidden galleries, etc.  UnGallery faces a few unique challenges in leaving the WordPress environment and connecting to external image directories.  To help, tips and the WordPress plugin forum are available to answer questions or issues that arise.  

= Why are the images are not displaying? =
The path to the image directory is the most common issue.  It must be an absolute path from the file system root like: "/home/username/your/images/" and not a relative path like:  "../your/images/".  The trailing slash/ is required.  UnGallery will try to display the path to your WordPress install on the admin page as a suggestion.  If you have shell access to your WordPress installation, you can type: "pwd" from the command line in your images directory to display the path.

Another common issue is the UnGallery permalink does not match the permalink of the gallery page.  Please see installation step 3.

= Why does does the admin page say it cannot create the cache directory? =
Permissions on the file system or security on the web server may prevent the plugin from creating the directory automatically.  It can be created manually by typing the following commands from the WordPress installation directory:
<pre><code>mkdir wp-content/cache/
chmod 777 wp-content/cache/</code></pre>
<br>
<br>
= How are the images sorted? =
Images are sorted alphabetically.  Alphabetical sorting actually provides ability to include some chronological sorting.  For example pictures taken on digital cameras tend to use formats like:  
<pre><code>-rwxrwxrwx   1.3M Dec 24 08:20 IMG_9558.JPG
-rwxrwxrwx   1.3M Dec 24 08:24 IMG_9559.JPG
-rwxrwxrwx   1.4M Dec 24 08:24 IMG_9560.JPG</code></pre>
<br>
<br>
So the default naming convention for many already does sort by time.  And if the time stamps are ever lost like some archiving or file transfer actions can do, they'll still remain in time order:
<pre><code>-rw-rw-r--   47K 2010-08-30 17:59 DSCF0061.JPG
-rw-rw-r--   40K 2010-08-30 17:59 DSCF0063.JPG
-rw-rw-r--   68K 2010-08-30 17:59 DSCF0064.JPG
</code></pre>
<br>
<br>
And they can be modified to suit a custom ordering scheme:
<pre><code>-rw-rw-r-- 1 pg1720424  72K 2010-08-30 17:58 1.jpg
-rw-rw-r-- 1 pg1720424  49K 2010-08-30 17:58 2.jpg
-rw-rw-r-- 1 pg1720424  56K 2010-08-30 17:58 3.jpg</code></pre>

== Changelog ==
= 2.1.1 =
* Updated thumbnail sort order
= 2.1.0 =
* Added checkbox to admin page to make zip link optional.
* Removed the marquee feature.
= 2.0.5 =
* Port search fix to non-fancyBox option.
= 2.0.4 =
* Top level search bug fixed.
* New screencast linked from install page
= 2.0.3 =
* Configuration menu updated.
= 2.0.2 =
* Instructions updated
= 2.0.1 =
* Screenshots updated.
= 2.0 =
* UnGallery now supports (but does not require) integration with fancyBox lightbox application.
= 1.7.4 =
* Fixed the search always redirecting to my own site.  Oops!  Sorry folks.  Not the best way to drive traffic to me. =)
* Searches are no longer case sensitive.
= 1.7.4 =
*Changed default thumbnail columns and size to match default WP theme
* Extended configuration page fields to display longer paths clearly
= 1.7.3 =
* Removed spaces from URL displayed on configuration page
* An .htaccess file is now created in the cache directory to prevent direct browser access.
* Removed legacy thumb_cache masking code
= 1.7.2 =
* Moved movie playback to render in its own window.  Removing the WordPress frame seems to clear a lot of browser compatibility problems.
= 1.7.1 =
* Living in svn tagging hell.
= 1.7.0 =
* Needed 3 digit tagging to allow automatic updates.
= 1.6.1 =
* Searching form field now included in the gallery inline, excludes hidden galleries, and is relative to whatever level of the gallery tree you are viewing.
= 1.6 =
* Add first rev of files and directory searching using keywords.  Currently this is via appending "&search=your_search" toURI. So for example: http://markpreynolds.com/gallery?gallerylink=&search=squirrel
= 1.5.17 =
* svn did not pick up new files. Adding and incrementing version.
= 1.5.16 =
* Removed phpThumb's auto rotation call as it causes OOM error on weenie providers like Dreamhost.
= 1.5.15 =
* Prevented relative paths in zip logic
= 1.5.14 =
* Added support for streaming video and zip archive content types back.
* Corrected security for above content types.
* Removed warning message on first time create of each pics.zip
* Removed duplicate compression message.
= 1.5.13 =
* Fixed thumbnails not rotating
= 1.5.11 =
* More auto rotate clean up
= 1.5.10 =
* Removed the auto rotate on the full sized download version which seems to cause phpThumb to choke on large files
= 1.5.9 =
* Disabled movie display feature due to similar security issue as zip file.  Will add back later if possible.
= 1.5.8 =
* Disabled zip archiving feature due to security issue.  Will add back later if possible.
= 1.5.7 =
* Update version tags
= 1.5.6 =
* Disabled phpThumb's SafeExec function due to security flaw
= 1.5.5 =
* If there are no subgalleries, we no longer display the "Subgalleries: " text
* Updated doc with PHP 5.x prerequisite
= 1.5.4 =
* Column option added back to correct problem with IE wrapping thumbnails.
= 1.5.3 =
* Corrected zip file bug
= 1.5.2 =
* Support for total of 6 top-level galleries added.
= 1.5.1 =
* Doc/Readme updates
= 1.5.0 =
* Custom permalinks no longer required.
= 1.4.5 =
* An extra space in configuration_menu.php was causing various header errors.  Fixed.
= 1.4.2 =
* Version update/correction
= 1.4.1 =
* Corrected issue where plugin always executes.  
* FAQ updates.
= 1.4.0 =
* Support for up to 4 distinct galleries.
* UnGallery settings page updated with new support section.
* Plugin page updated with links to Settings page, Support Forum, FAQ, Donate 
= 1.3.3 =
* Caching disables on error when rendering phpThumb images
* Error handling added to create cache directory process on plugin admin page
* Originals now streamed directly instead of via phpThumb library
* Cache directory now set using DOCUMENT_ROOT instead of relative to configuration_menu.php
= 1.3.2 =
* Gallery images, title are centered even if your theme sets other justify
* Number of columns setting is removed.  This can be set by adjusting thumbnail size on admin page.
* First non-trunk stable release
= 1.3.1 =
* Gallery images are centered (unless your theme forces justify)
* Started tagging releases
= 1.3.0 =
* Gallery titles are centered (unless your theme forces justify)
* Banner file handling updates, sample banner.txt included.
= 1.2.0 =
* BMP's now supported
= 1.1.5 =
* phpThumb is apparently no longer supported and so did not support php 5.3.  Others have extended the code though and this patch fixes UnGallery running on a php 5.3 server.
* phpThumb library handles the original pic and autorotation
= 1.1.4 =
* phpThumb calls set_time_limit which is not supported in safe.  Disabled for now, potential conditional for later.
* Removed cache limits
= 1.1.3 =
* Changed the create cache directory code to use PHP function vs. exec php which is not allowed on some hosters
= 1.1.2 =
* Admin menu file was incomplete, causing serious bug when not using gallery name: 'gallery'
= 1.1.1 =
* Oops.  Forgot to svn add the phpThumb script subdirectory.
* Also, some version number increments do not trigger automatic update and flag as recent on wp.org
= 1.1.0 =
* Upgraded the thumbnail library to phpThumb which enables many new imaging options.
* Caching no longer writes to image directories. Cache dir is ./WordPress installation/wp-content/cache/ is created
= 1.0.4 =
* First integrated support tips/tool added (pwd)
= 1.0.3 =
* Consolidated thumbnail creation files in preparation to update that library
* Fixed a regression in zip file download
= 1.0.2 =
* Version number is displayed on admin menu page and noted in html
= 1.0.1 =
* Version format updated
* Hidden gallery field added to those auto-populated if blank
* Introduction and installation screencast 
= 1.0 =
* Administration menus auto-populate with default values when blank
* Instructions updated for new configuration
= 0.9.9 =
* Due to WP plugin automatic updates deleting and replacing the plugin directory, your images (and any other valuable user data) should **not** be stored in the plugin directory
* Versioning readded, plugin updates reactivated
* WordPress Plugin menu screen replaces configuration files
= 0.9.6 =
* Versioning removed to disable automatic updates
= 0.9.5 =
* You no longer need to call the gallery: "gallery".  Any name can be used.
* Fixed issue with extra character in hidden.txt causing mismatch
= 0.9.4 =
* Fixed issue with some browsers not playing mp4
* Fixed case sensitivity problem with .mp4/MP4
* Fixed erroneously reporting plugin download needed for directories with no image files.
= 0.9.3 =
* Fixed issue with IE downloading zip archives of images
= 0.9.2 =
* Added top-level gallery logic to toggle marquee and zip display behavior
* Added support for custom WordPress and Site addresses
= 0.9.1 =
* Added hardening code and replaced relative links with absolute links
= 0.9 =
* MP4's are now embedded and integrated into the WP site frame.  Support for older movie formats is deprecated.
* Current directory breadcrumb link added.  This allows returning to the thumbnail list from the web-size browse view.
* Compatibility for WP 3.0's default twentyten theme that broke UnGallery's browse view.

== Dependencies ==

* Linux on the WordPress server
* PHP 5

== Notes ==

* All image sizes including thumbnails, selected image view, movies, and column layout are customizable.
* To display a caption over a gallery, add a file named banner.txt to that directory with the desired text.  The file can include plain text or html. If no banner.txt is found, the name of the directory used.
* To mark a gallery hidden, enter a name for hidden galleries on the UnGallery administration page. Any directories you create named "hidden", will not be visible via normal gallery browsing. A direct link may be sent to provide access to hidden galleries.  
* You can include UnGallery images in other areas of your WordPress site or other sites by embedding the URL from UnGallery into the external site.

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


