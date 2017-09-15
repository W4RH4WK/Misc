<?php
/* \file
 *
 * This component allows you do write single page blog entries. Each blog entry 
 * is a file ether with .html or .md as extension like the Pages componenet manages its files.
 *
 * If no entry is specified, the latest will be shown.
 *
 * Store images in the gfx folder.
 *
 * Each file must start with a date, an '_' to seperate the date from title. 
 * Spaces should be replaced with '-'.
 *   Ex: 2012-02-31_my-blog-entry.md
 *
 * Call:
 *   ?run=Blog
 *
 * Extension:
 *   Each file's php code is parsed.
 *   Files with 'md' extension are additionally parsed with markdown to html
 *
 */

// -- include
include_once("lib/Helper.php");

// -- functions
function printList($l) {
    foreach ($l as $k => $v) {
        echo "<ul>\n";
        echo "<li class=\"name\">$k</li>\n";
        foreach ($v as $f) {
            $date = substr($f, 0, 10);
            $file = str_replace("-", " ", pathinfo(substr($f, 11), PATHINFO_FILENAME));
            echo "<li class=\"entry\"><a href=\"?run=Blog&amp;e=$f\"><span class=\"date\">".$date."</span> ".$file."</a></li>\n";
        }
        echo "</ul>\n";
    }
}

// -- script
// get list
$list = array();
foreach (scandir("inc/Blog", 1) as $f) {
    if ($f == "." || $f == ".." || $f == "index.php" || $f == "gfx") continue;
    $y = substr($f, 0, 4);
    if (isset($list[$y]))
        $list[$y][] = $f;
    else
        $list[$y] = array($f);
}

// get entry
if (isset($_GET["e"]) && is_readable("inc/Blog/".pathinfo($_GET["e"], PATHINFO_BASENAME))) {
    $e = $_GET["e"];
} else {
    // show latest
    $e = $list;
    $e = current($e);
    $e = current($e);
}

?>
<div class="row-fluid" id="blog">
    <div class="span4" id="list"><?php printList($list); ?></div>
    <div class="span8" id="entry"><?php printFile("inc/Blog/$e"); ?></div>
</div>
