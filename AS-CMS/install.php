<?php
/** install script
 *
 * this script should be used to setup ASCMS, in order to do that, follow the 
 * install information in the wiki (link in readme file).
 *
 * after editing config.php you set username and password for the 
 * administrator in this file. This script will add the admin to the database 
 * so you can login and edit page content.
 *
 * before creating the user, this script will scan the inc directory for 
 * components which implement the Installable interface. If they do, the 
 * Install() method is run.
 */

// -- new administrator
$user = "";
$pass = "";

// -- get core
require_once("Core.php");

// register config
global $config;

// -- run Install()
foreach (scandir("inc") as $f) {
    if ($f == "." || $f == "..")
        continue;

    // load component
    $c = Core::load("", $f);

    // run install if possible
    if ($c instanceof Installable) {
        // print msg
        echo "installing: " . $f . "<br />\n";

        // install
        if (isset($config[$f]))
            $c->Install($config[$f]);
        else
            $c->Install(array());
    }
}

// -- add user
Core::load("", "Admin")->addUser($user, $pass, "*");

?>
