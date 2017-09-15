<?php
/** post install
 *
 * this component allows you to run the install method by hand
 */

class PostInstall implements Adminable {

    public function Admin() {
        // handle actions
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "install") {
                if (isset($_POST["component"])) {
                    // register config
                    global $config;

                    // install
                    if (isset($config[$_POST["component"]]))
                        Core::load("", $_POST["component"])->Install($config[$_POST["component"]]);
                    else 
                        Core::load("", $_POST["component"])->Install(array());
                } else {
                    trigger_error("no component given");
                }
            } else {
                trigger_error("unknown action");
            }
        }

        return Core::inc("inc/".get_class($this)."/view.php", array("name" => get_class($this)));
    }
}

?>
