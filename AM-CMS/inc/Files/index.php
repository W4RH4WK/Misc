<?php
/** \file
 *
 * This component works like a simple directory listing. It shows you files 
 * located in the 'up' directory and enables you to browse it's subdirectories.
 *
 * Call:
 *   ?run=Files
 *   or
 *   ?run=Files&p=/SUB/FOLDER
 *
 */

// -- include
include_once("lib/Helper.php");

// -- function
function printDir($p) {
    // file list
    foreach (scandir("inc/Files/up$p") as $f) {
        // skip crap
        if ( $f == "." || $f == "..") continue;

        if (is_dir("inc/Files/up$p/$f"))
            echo "<i class=\"icon-folder-close\"></i> <a href=\"?run=Files&amp;p=$p/$f\">$f</a><br />\n";
        else
            echo "<i class=\"icon-file\"></i> <a href=\"inc/Files/up$p/$f\">$f</a><br />\n";
    }
}

// -- script
// get path
$p = isset($_GET["p"]) ? $_GET["p"] : "";

if (strpos($p, "..") === false)
    if (is_dir("inc/Files/up$p")) {
        printBreadcrumb($p, "?run=Files", "?run=Files&amp;p=");
        printDir($p);
    } else {
        trigger_error("inc/Files/up$p is not a valid directory");
    }
else
    trigger_error("'..' is not allowed");

?>
