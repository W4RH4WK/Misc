<?php
/** \file
 *
 * This component shows static pages stored as files. Each page is identified 
 * via its filename and path. The file's content is pasted upon call. The path 
 * is relative to 'inc/Pages' but must start with a '/'.
 *
 * Call:
 *   ?run=Pages&p=/FILENAME
 *   or
 *   ?run=Pages&p=/PATH/TO/FILE
 *
 * Extension:
 *   Each file's php code is parsed.
 *   Files with 'md' extension are additionally parsed with markdown to html
 *
 * If the selected path is a directory, a file listing will be printed.
 *
 */

// -- include
include_once("lib/Helper.php");

// -- functions
function printDir($p) {
    // file list
    foreach (scandir("inc/Pages$p") as $f) {
        // skip crap
        if ( $f == "." || $f == ".." || $f == "index.php") continue;

        if (is_dir("inc/Pages$p/$f"))
            echo "<i class=\"icon-folder-close\"></i> <a href=\"?run=Pages&amp;p=$p/$f\">$f</a><br />\n";
        else
            echo "<i class=\"icon-file\"></i> <a href=\"?run=Pages&amp;p=$p/$f\">$f</a><br />\n";
    }
}

// -- script
// get path
$p = isset($_GET["p"]) ? $_GET["p"] : "";

if (strpos($p, "..") === false)
    if (is_dir("inc/Pages$p")) {
        printBreadcrumb($p, "?run=Pages", "?run=Pages&amp;p=");
        printDir($p);
    } else {
        printFile("inc/Pages$p");
    }
else
    trigger_error("'..' is not allowed");

?>
