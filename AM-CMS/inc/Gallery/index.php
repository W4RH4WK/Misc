<?php
/* \file
 * This component shows pictures like a gallery usually does. Lightbox is used 
 * to show the pictures. Just put the pictures somehwere in the 'up' folder (if 
 * you want, located within subfolders)
 *
 * To (re)generate thumbnails: make sure there is _NO_ folder called 'thumbs' 
 * in this folder. The thumbnails will be generated when the component is 
 * invoked. 
 *
 * Call:
 *   ?run=Gallery
 *
 * Filetypes:
 *   .jpg and .png are supported
 *
 */

// -- include
include_once("lib/Helper.php");
Core::addHead("<link rel=\"stylesheet\" type=\"text/css\" href=\"inc/Gallery/style.css\" />");

// -- functions
function recreateThumbnails($p) {
    // create dir
    mkdir("inc/Gallery/thumbs$p", 0777);

    // create thumbnails
    foreach (scandir("inc/Gallery/up$p") as $f) {
        if ($f == "." || $f == "..") continue;
        if (is_dir("inc/Gallery/up$p/$f")) {
            recreateThumbnails("$p/$f");
        } else {
            createThumbnail("inc/Gallery/up$p/$f", "inc/Gallery/thumbs$p", 150);
        }
    }
}

function printFolders($p) {
    foreach (scandir("inc/Gallery/up$p") as $f) {
        if ($f == "." || $f == "..") continue;

        // print
        if (is_dir("inc/Gallery/up$p/$f")) {
            echo "<i class=\"icon-folder-close\"></i> <a href=\"?run=Gallery&amp;p=$p/$f\">$f</a><br />\n";
        }
    }
}

function printPictures($p) {
    foreach (scandir("inc/Gallery/up$p") as $f) {
        if ($f == "." || $f == "..") continue;

        // check extension and print
        $ext = pathinfo($f, PATHINFO_EXTENSION);
        if ($ext == "jpg" || $ext == "png") {
            echo "<a href=\"inc/Gallery/up$p/$f\" rel=\"lightbox[gallery]\" 
                title=\"$f\" rel=\"tooltip\" data-original-title=\"$f\"><img 
                src=\"inc/Gallery/thumbs$p/$f\" /></a>\n";
        }
    }
}

// -- script
// recreate thumbnails if needed
if (!is_dir("inc/Gallery/thumbs"))
    recreateThumbnails("");

// get path
$p = isset($_GET["p"]) ? $_GET["p"] : "";

if (strpos($p, "..") === false) {
    if (!is_dir("inc/Gallery/up$p")) {
        trigger_error("inc/Gallery/up$p is not a valid directory");
        $p = "";
    }
} else {
    trigger_error("'..' is not allowed");
}

?>

<div id="path"><?php printBreadcrumb($p, "?run=Gallery", "?run=Gallery&amp;p="); ?></div>
<div class="row-fluid" id="gallery">
    <div class="span3" id="folder"><?php printFolders($p); ?></div>
    <div class="span9" id="files"><?php printPictures($p); ?></div>
</div>

<script type="text/javascript">
    // setup tooltips
    $("#files a").tooltip({placement:"bottom"});
</script>
