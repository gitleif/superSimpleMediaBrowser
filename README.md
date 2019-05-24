# superSimpleMediaBrowser
# Just for fun, simple PHP class to list all medias in a folder amd return it as an array.
# Used for Arnes project.

# Quickstart ----------------
#Usage - Initialise
#$cls = new superSimpleMediaBrowser("http://localhost/", "");

#Usage - Index a folder with images
#E.g: This index all of the images pictures2018 subfolder in the document root folder.

$cls->buildMediaDataFile($_SERVER['DOCUMENT_ROOT'] . "/pictures2018/", true);
# This will create a .php file and save it to the folder.

#Usage - Read indexed file.

$Files = $cls->parseMediaDataFile();
# returns all indexed files in the current folder.
