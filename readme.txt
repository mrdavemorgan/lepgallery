=== Lepgallery ===
Contributors: mmond, mrdavemorgan
Tags: gallery, lepgallery, ungallery, pictures, jpg, png, gallery, photos, browse, images, lightbox
Requires at least: 
Tested up to: 3.5
TODO: specify a version
Stable tag: 2.2.2

Publish large image libraries with hierarchy. Based on UnGallery by Mark Reynolds.

== Description ==

Lepgallery displays your directories of images as a browsable WordPress gallery. 

The advantage of Lepgallery is there is there is no gallery management required in WordPress.  You just point the plugin to a directory  of photos and they are immediately viewable via an existing WordPress site.  Any uploads, deletions, or edits you make to your photos and directory organization are automatically reflected in WordPress.

If you've ever had to reorganize galleries after publishing, you know how inconvenient it is to return to a web tool to correct the paths, relink the thumbnails, update titles, etc.   With Lepgallery, you can restructure entire galleries, edit a dozen party pic red-eyes, rename an event or remove individual photos and each of these changes is automatically live in WordPress.

This was a fork of the original UnGallery plugin by Mark Reynolds. It was then optimized for browsing taxonomic hierarchies of moth/butterfly photos, and was adapted to use Lightbox2 instead of FancyBox. At this point most of the code has been reworked, but it never would have gotten off the ground without UnGallery as a base. If Lepgallery lacks some of the features you need (search, zip, videos, etc.) you should also give the original UnGallery a try.

== Installation ==

1. Download to ./wp-content/plugins/ and activate via the Plugins menu.
2. Create a blank WordPress Page, for example one called "Gallery".
3. Set the body text of your page to be like this:
	{lepgallery=/filesystem/path/to/your/gallery/folder/}
3. Profit :)

The Lepgallery steps above are simple and the install is generally quick.  However because the plugin works outside the WordPress environment and communicates with the web server file system, there are sometimes challenges troubleshooting the install.  It helps to have a bit of familiarity with Linux commands and paths. Several tips and tools to help you install are built into Lepgallery's plugin settings page.

== Features ==

* Unlimited depth, breadth, and number of photos in library.
* Photos are managed outside of WordPress.  Simply update a picture directory and Lepgallery sees changes immediately.
* Default and configurable gallery titles
* Caching for faster page loads
* Gallery hierarchy breadcrumb links

== Screenshots ==

1. The photo detail view.
2. The Lepgallery default view with subdirectories/subgalleries, breadcrumbs etc.

== Changelog ==


== Dependencies ==

* Linux on the WordPress server
* PHP 5

== Notes ==

* All image sizes including thumbnails, selected image view, and column layout are customizable.
* To display a caption over a gallery, add a file named banner.txt to that directory with the desired text.  The file can include plain text or html. If no banner.txt is found, the name of the directory used.
* Similarly, you can specify the name to be displayed for a particular folder by putting a title.txt in that folder. (This should be plain text, not HTML). This will appear instead of the folder name for the breadcrumbs and subgallery links.
* You can also override the caption displayed for a particular image by taking the full image name and creating a text file with that name and ".txt" appended. (Example: homer_birthday_014.jpg.txt) By default, the caption will just be the image's filename.
* You can include Lepgallery images in other areas of your WordPress site by putting the {lepgallery} text tag in the body text. The gallery will be loaded from any path specified in the tag.

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


