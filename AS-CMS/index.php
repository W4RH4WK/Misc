<?php
/** \file
 *
 * this file is the main entry point for all page requests.
 * the dispatchers go here
 *
 */

// load core
require_once("Core.php");

// ajax dispatcher (minimal overhead)
if (isset($_GET["ajax"])) {
    // set content type
    header("Content-Type: text/xml");

    // load instance
    $obj = Core::load("", $_GET["ajax"]);

    // do ajax callout if possible
    if ($obj instanceof Ajaxable)
        echo $obj->Ajax();

    // stop executing
    exit();
}

// try to login
if (isset($_POST["user"]) && ($_POST["user"] != "") && isset($_POST["pass"]) && ($_POST["pass"] != "")) {
    Core::load("Admin")->login($_POST["user"], $_POST["pass"]);
    if (!Core::load("Admin")->isLoggedin())
        trigger_error("invalid login data");
}

// try to logout
if (isset($_GET["logout"])) {
    Core::load("Admin")->logout();
    header("location: index.php");
}

// dispatch non-ajax calls
if (isset($_GET["admin"])) { 
    // check for login
    if (Core::load("Admin")->isLoggedin()) {
        // check for permission
        if (Core::load("Admin")->checkPerm($_GET["admin"])) {
            // load instance
            $obj = Core::load("", $_GET["admin"]);

            // run component
            if ($obj instanceof Adminable)
                Core::load("Page")->setContent($obj->Admin());
            else
                trigger_error($_GET["admin"] . " is not adminable");
        } else {
            trigger_error("no permission for this component");
        }
    } else {
        trigger_error("not logged in");
    }
} else {
    // check for default
    if (!isset($_GET["run"])) {
        global $config;
        parse_str($config["ASCMS"]["defaultPath"], $_GET);
    }

    // load instance
    $obj = Core::load("", $_GET["run"]);

    // run component
    if ($obj instanceof Runable)
        Core::load("Page")->setContent($obj->Run());
    else
        trigger_error($_GET["run"] . " is not runable");
}

echo Core::load("Page")->show();

?>
