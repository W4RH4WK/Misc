<?php
/** custom page component
 *
 * this component can be used to create custom pages.
 * the code for the page is stored in the database, you can also use markdown 
 * to style the page.
 *
 */

class CustomPage implements Runable, Adminable, Ajaxable, Installable {

    private $cfg;

    function __construct($cfg) {
        $this->cfg = $cfg;
    }
    
    public function Run() {
        if (isset($_GET["id"])) {
            // get data
            $entry = Core::load("Mysql")->sel("CustomPage", array("id" => $_GET["id"]));

            // put text
            if ($entry[0]["markdown"] != "0")
                return Core::load("Wrapper")->renderMarkdown($entry[0]["text"]);
            else 
                return $entry[0]["text"];
        } else {
            trigger_error("no id provided");
        }
    }

    public function getNavEntries() {
        $res = Core::load("Mysql")->query("SELECT id, name FROM CustomPage;");

        while ($row = $res->fetch_assoc())
            $ret[$row["name"]] = "id=".$row["id"];

        return $ret;
    }

    public function Admin() {
        Core::load("Page")->enableMarkitup();

        // handle actions
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "new") {
                Core::load("Mysql")->ins(
                    "CustomPage",
                    array(
                        "name" => $_POST["name"],
                        "text" => $_POST["text"],
                        "markdown" => isset($_POST["markdown"]) ? "1" : "0"
                    )
                );

                // get id
                $id = Core::load("Mysql")->getInstance()->insert_id;

                // add nav entry
                if (isset($_POST["nav"]))
                    Core::load("Nav")->addLink($_POST["name"], "?run=CustomPage&id=".$id, 0, $this->cfg["NavMenuId"]);

                // add rss feed
                if (isset($_POST["rss"]))
                    Core::load("Rss")->add($this->cfg["RssFeed"], "New Page: ".$_POST["name"], "run=CustomPage&id=".$id, "a new page has just been added");

            } else if ($_POST["action"] == "edit") {
                Core::load("Mysql")->upd(
                    "CustomPage",
                    $_POST["id"],
                    array(
                        "name" => $_POST["name"],
                        "text" => $_POST["text"],
                        "markdown" => isset($_POST["markdown"]) ? "1" : "0"
                    )
                );
            } else if ($_POST["action"] == "remove") {
                Core::load("Mysql")->del("CustomPage", $_POST["id"]);
            } else {
                trigger_error("unknown action");
            }
        }

        // show entries
        $res = Core::load("Mysql")->query("SELECT id, name, markdown FROM CustomPage ORDER BY name;");
        $entries = array();
        while ($row = $res->fetch_assoc())
            $entries[] = $row;

        return Core::inc(
            "inc/".get_class($this)."/adminView.php",
            array(
                "entries" => $entries,
                "name" => get_class($this)
            )
        );
    }

    public function Ajax() {
        if (isset($_GET["action"])) {
            if ($_GET["action"] == "getText" && isset($_GET["id"])) {
                $entry = Core::load("Mysql")->sel("CustomPage", array("id" => $_GET["id"]));
                return htmlspecialchars($entry[0]["text"]);
            }
        }
    }

    public function Install($cfg) {
        // get instance
        $i = Core::load("Mysql")->getInstance();

        // do a multi query
        $i->multi_query(file_get_contents("inc/".get_class($this)."/dump.sql"));

        // use results to keep query flow alive
        do
            $i->use_result();
        while ($i->next_result());
    }
}

?>
