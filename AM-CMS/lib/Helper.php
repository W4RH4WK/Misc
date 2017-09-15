<?php
/** \file
 *
 * This file contains some helper functions for the cms
 *
 */

/** print file
 *
 * prints the content of a file. The content will be parsed for php code, and 
 * markdown if the file extension is '.md'
 *
 * \param   $f  filepath
 */
function printFile($f) {
    // check if readable
    if (is_readable($f))
        if (pathinfo($f, PATHINFO_EXTENSION) == "md")
            // render markdown to html and print out
            echo Core::renderMarkdown(Core::inc($f));
        else
            // print out
            echo Core::inc($f);
    else
        trigger_error("couldn't read file: $f");
}

/** print bread crumb
 *
 * prints a linked bread crumb line for easier navigation.
 *
 * \param   $path   current location
 * \param   $base   link for href (root element)
 * \param   $link   link for href (following elements)
 */
function printBreadcrumb($path, $base, $link) {
    // trim leading slash
    $path = substr($path, 1);

    echo "<ul class=\"breadcrumb\">\n";
    
    // root
    echo "<li><a href=\"$base\">Root</a> <span class=\"divider\">/</span><li>\n";

    // sub dirs
    if ($path != "") {
        $l = "";
        foreach (explode("/", $path) as $f) {
            $l .= "/".$f;
            echo "<li><a href=\"$link$l\">$f</a> <span class=\"divider\">/</span><li>\n";
        }
    }

    echo "</ul>\n";
}

/** create thumbnail
 *
 * creates a small thumbnail of a .jpg or .png picture.
 *
 * \param   $src        path to source file
 * \param   $dst        path to destination folder (no filename)
 * \param   $w          desired width (aspect ration won't change)
 */
function createThumbnail($src, $dst, $w) {
    // get filename
    $fn = pathinfo($src, PATHINFO_BASENAME);

    // get extension
    $ext = pathinfo($src, PATHINFO_EXTENSION);

    // get src image
    if ($ext == "jpg") {
        $source_image = imagecreatefromjpeg($src);
    } else if ($ext == "png") {
        $source_image = imagecreatefrompng($src);
    } else {
        trigger_error("$src not a .jpg or .png file");
        return;
    }

    $width = imagesx($source_image);
    $height = imagesy($source_image);

    // calc height according to given width
    $h = floor($height * ($w / $width));

    // create virtual
    $virtual_image = imagecreatetruecolor($w, $h);

    // copy src image
    imagecopyresized($virtual_image, $source_image, 0, 0, 0, 0, $w, $h, $width, $height);

    // create thumbnail
    if ($ext == "jpg" || $ext == "jpeg") {
        imagejpeg($virtual_image, "$dst/$fn", 83);
    } else if ($ext == "png") {
        imagepng($virtual_image, "$dst/$fn");
    }
}

?>
