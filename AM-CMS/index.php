<?php
/** \file
 *
 * This is the main entry point for all page requests. The default path is 
 * definied here.
 *
 */

// load core
require_once("Core.php");

// default path
$defaultPath = "run=Pages";

// check for default
if (!isset($_GET["run"])) {
    parse_str($defaultPath, $_GET);
}

// load template
echo Core::inc(
    "style/page.html",
    array(
        "c" => Core::inc("inc/".$_GET["run"]."/index.php"),
        "h" => Core::getHead()
    )
);

?>
