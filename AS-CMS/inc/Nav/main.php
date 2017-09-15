<?php
/** nav component
 *
 * this component manages navigation bars. all navigation entries are 
 * organaized in menues.
 *
 * \note
 *      there are bootstrap options for using nav-pils with and without 
 *      dropdown menues
 *
 */

class Nav implements Adminable, Ajaxable, Installable {

    /** show
     *
     * this method returns a given menu (with 1 level of submenues and links) 
     * as printable HTML code
     *
     * \param   $menu   menu, which should be printed
     * \param   $type   the style it should be printed
     * \return  HTML code
     */
    public function show($menu, $type="list") {
        $ret = "";

        // get structured menu
        $m = $this->getMenu($menu);

        if ($type == "debug") {
            // print without special code
            $ret = $m->label."\n";
            foreach ($m->storage as $e) {
                if ($e instanceof NavMenu) {
                    $ret .= "  ".$e->label."\n";
                    foreach ($e->storage as $ee)
                        $ret .= "    - ".$ee->label."\n";
                } else {
                    $ret .= "  - ".$e->label."\n";
                }
            }
        } else if ($type == "list") {
            foreach ($m->storage as $e) {
                if ($e instanceof NavMenu) {
                    $ret .= "    <ul>".$e->label."\n";
                    foreach ($e->storage as $ee)
                        $ret .= "        <li><a href=\"".htmlspecialchars($ee->link)."\">".$ee->label."</a></li>\n";
                    $ret .= "    </ul>\n";
                } else {
                    $ret .= "    <li><a href=\"".htmlspecialchars($e->link)."\">".$e->label."</a></li>\n";
                }
            }
            $ret = "<ul>\n".$ret."</ul>\n";
        } else if ($type == "bootstrap") {
            foreach ($m->storage as $e) {
                if ($e instanceof NavMenu) {
                    $ret .= "  <li class=\"dropdown\"><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\">".$e->label." <b class=\"caret\"></b></a>\n";
                    $ret .= "    <ul class=\"dropdown-menu\">\n";
                    foreach ($e->storage as $ee)
                        $ret .= "      <li><a href=\"".htmlspecialchars($ee->link)."\">".$ee->label."</a></li>\n";
                    $ret .= "    </ul>\n  </li>\n";
                } else {
                    $ret .= "  <li><a href=\"".htmlspecialchars($e->link)."\">".$e->label."</a></li>\n";
                }
            }
            $ret = "<ul class=\"nav nav-pills\">\n".$ret."</ul>\n";
        } else if ($type == "raw") {
            return $m;
        }

        // gtfo
        return $ret;
    }

    /** get menu
     *
     * grabs data from database to return a well structured menu
     *
     * \param   $menu   menu to grab
     * \return  the menu as data structure
     */
    private function getMenu($menu) {
        // grab the root
        $r = Core::load("Mysql")->sel("NavMenu", array("label" => $menu));
        if (empty($r)) {
            trigger_error("couldn't find menu $menu");
            return;
        }
        $r = $r[0];
        $ret = new NavMenu($r["id"], $r["label"], $r["parent"], $r["sort"]);

        // fill with submenus
        $sm = Core::load("Mysql")->sel("NavMenu", array("parent" => $ret->id));
        foreach ($sm as $s)
            if ($s["id"] != $s["parent"])
                $ret->add(new NavMenu($s["id"], $s["label"], $s["parent"], $s["sort"]));

        // fill root with links
        $ls = Core::load("Mysql")->sel("NavLink", array("menu" => $ret->id));
        foreach ($ls as $l)
            $ret->add(new NavLink($l["id"], $l["menu"], $l["label"], $l["link"], $l["sort"]));

        // fill each submenu with links
        foreach ($ret->storage as $e) {
            if ($e instanceof NavMenu) {
                $ls = Core::load("Mysql")->sel("NavLink", array("menu" => $e->id));
                foreach ($ls as $l)
                    $e->add(new NavLink($l["id"], $l["menu"], $l["label"], $l["link"], $l["sort"]));
            }
        }

        // sort submenus
        foreach ($ret->storage as $e)
            if ($e instanceof NavMenu)
                usort($e->storage, "Nav::sortCompare");

        // sort root menu
        usort($ret->storage, "Nav::sortCompare");

        // get out
        return $ret;
    }

    /** sort compare
     *
     * this function is used as compare function for usort
     */
    public static function sortCompare($a, $b) {
        if ($a->sort != $b->sort)
            return $a->sort - $b->sort;
        else
            return $a->id - $b->id;
    }

    /** add menu
     *
     * this function adds a new menu
     *
     * \param   $label  the menu's label
     * \param   $parent the parent menu's id
     * \param   $sort   sortindex
     */
    public function addMenu($l, $p=1, $s=0) {
        // insert
        Core::load("Mysql")->ins("NavMenu", array(
            "label" => $l,
            "parent" => $p,
            "sort" => $s
        ));
    }

    /** add link
     *
     * this function adds a new link
     *
     * \param   $label  the link's label
     * \param   $link   the link itself
     * \param   $sort   sortindex
     * \param   $menu   the menu it belongs
     */
    public function addLink($la, $li, $s=0, $m=1) {
        Core::load("Mysql")->ins("NavLink", array(
            "menu" => $m,
            "label" => $la,
            "link" => $li,
            "sort" => $s
        ));
    }

    /** admin method
     *
     * - is called upon administration
     */
    public function Admin() {
        // handle actions
        if (isset($_POST["action"])) {
            if ($_POST["action"] == "new-menu") {
                $this->addMenu($_POST["label"], $_POST["parent"], $_POST["sort"]);
            } else if ($_POST["action"] == "new-link") {
                // set link
                if ($_POST["link-combobox0"] == "custom") {
                    $link = $_POST["link-text"];
                } else {
                    if ($_POST["link-combobox1"] == null) {
                        $link = "?run=".$_POST["link-combobox0"];
                    } else {
                        $link = "?run=".$_POST["link-combobox0"]."&".$_POST["link-combobox1"];
                    }
                }

                // insert
                $this->addLink($_POST["label"], $link, $_POST["sort"], $_POST["menu"]);
            } else if ($_POST["action"] == "edit-menu") {
                Core::load("Mysql")->upd(
                    "NavMenu",
                    $_POST["id"],
                    array(
                        "label" => $_POST["label"],
                        "parent" => $_POST["parent"],
                        "sort" => $_POST["sort"]
                    )
                );
            } else if ($_POST["action"] == "edit-link") {
                Core::load("Mysql")->upd(
                    "NavLink",
                    $_POST["id"],
                    array(
                        "menu" => $_POST["menu"],
                        "label" => $_POST["label"],
                        "link" => $_POST["link"],
                        "sort" => $_POST["sort"]
                    )
                );
            } else if ($_POST["action"] == "remove-menu") {
                if ($_POST["id"] == 1) 
                    trigger_error("can't remove root menu");
                else
                    Core::load("Mysql")->del("NavMenu", $_POST["id"]);
            } else if ($_POST["action"] == "remove-link") {
                Core::load("Mysql")->del("NavLink", $_POST["id"]);
            } else {
                trigger_error("unknown action");
            }
        }

        // get all links / menus
        $entries = array();

        // get root menus
        $menus = array();
        foreach (Core::load("Mysql")->sel("NavMenu", array("parent" => 0)) as $e)
            $menus[] = $e["label"];

        // get dangling menus (root less menus)
        $res = Core::load("Mysql")->query("SELECT m1.label AS label FROM NavMenu AS m0 RIGHT JOIN NavMenu AS m1 ON m1.parent = m0.id WHERE m0.parent IS NULL AND m1.parent!='0'");
        while ($row = $res->fetch_assoc())
            $menus[] = $row["label"];
        $res->free();

        // get menus which are their own parent
        $res = Core::load("Mysql")->query("SELECT * FROM NavMenu WHERE id = parent");
        while ($row = $res->fetch_assoc())
            $menus[] = $row["label"];
        $res->free();

        // fill strucutre
        foreach ($menus as $m)
            $entries[] = $this->getMenu($m);

        // add dangling links
        $res = Core::load("Mysql")->query("SELECT l.id AS id, l.menu AS menu, l.label AS label, l.link AS link, l.sort AS sort FROM NavLink AS l LEFT JOIN NavMenu AS m ON l.menu = m.id WHERE m.label IS NULL");
        while ($row = $res->fetch_assoc())
            $entries[] = new NavLink($row["id"], $row["menu"], $row["label"], $row["link"], $row["sort"]);
        $res->free();

        // get view
        Core::load("Page")->addHead("<link rel=\"stylesheet\" type=\"text/css\" href=\"inc/".get_class($this)."/style.css\" />");
        return Core::inc("inc/".get_class($this)."/adminView.php",
            array(
                "entries" => $entries,
                "name" => get_class($this)
            )
        );
    }

    /** ajax method
     *
     * - is called upon ajax callout
     */
    public function Ajax() {
        if (isset($_GET["action"])) {
            if ($_GET["action"] == "getEntries" && isset($_GET["c"])) {
                $c = Core::load("", $_GET["c"]);
                if ($c instanceof Runable) {
                    $entries = $c->getNavEntries();

                    $ret = "";
                    foreach ($entries as $k => $v) {
                        $ret .= "<option value=\"".$v."\">".$k."</option>\n";
                    }

                    return $ret;
                }
            }
        }
    }


    /** install method
     *
     * - is called upon installing
     */
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

class NavLink {
    public $id;
    public $menu;
    public $label;
    public $link;
    public $sort;

    function __construct($id, $menu, $label, $link, $sort) {
        $this->id = $id;
        $this->menu = $menu;
        $this->label = $label;
        $this->link = $link;
        $this->sort = $sort;
    }
}

class NavMenu {
    public $id;
    public $label;
    public $parent;
    public $sort;

    public $storage;

    function __construct($id, $label, $parent, $sort) {
        $this->id = $id;
        $this->label = $label;
        $this->sort = $sort;
        $this->parent = $parent;

        $this->storage = array();
    }

    public function add($e) {
        $this->storage[] = $e;
    }
}

?>
