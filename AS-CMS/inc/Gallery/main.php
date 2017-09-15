<?php
/** gallery component
 *
 * this component features a basic concept of a gallery, it enables you to 
 * upload images, which can be viewed in the page (using lightbox). You can 
 * create tags to group images together.
 *
 * \note currently only jpg and png are supported formats
 */

class Gallery implements Runable, Adminable, Ajaxable, Installable {

    public function Run() {
        // get tag + files
        if (isset($_GET["tag"])) {
            $e = Core::load("Mysql")->sel("Gallery", array("tag" => $_GET["tag"]));
            $tag   = $e[0]["tag"];
            $files = explode(":", $e[0]["files"]);
            if ($files[0] == "") unset($files[0]);
        } else {
            $tag = "All";
            $files = array();
            foreach (scandir("inc/".get_class($this)."/up") as $f) {
                if ($f == "." || $f == ".." || $f == "thumb") continue;
                $files[] = $f;
            }
        }

        // get tags
        $tags = array();
        $res = Core::load("Mysql")->query("SELECT tag FROM Gallery ORDER BY tag");
            if ($res != null) {
            while ($row = $res->fetch_assoc())
                $tags[] = $row["tag"];
            $res->free();
        }

        // add style
        Core::load("Page")->addHead("<link rel=\"stylesheet\" type=\"text/css\" href=\"inc/".get_class($this)."/style.css\" />");

        // print view
        return Core::inc(
            "inc/".get_class($this)."/view.php",
            array(
                "files" => $files,
                "name" => get_class($this),
                "tag" => $tag,
                "tags" => $tags
            )
        );
    }

    public function getNavEntries() {
        $entries = Core::load("Mysql")->sel("Gallery");

        $ret = array(" - All - " => "");
        foreach ($entries as $e)
            $ret[$e["tag"]] = "tag=".$e["tag"];

        return $ret;
    }

    public function Admin() {
        if (isset($_GET["action"]) && $_GET["action"] == "recreateThumbs")
            $this->recreateAllThumbnails();

        if (isset($_POST["action"])) {
            if ($_POST["action"] == "new-tag") {
                // implode files
                if (isset($_POST["files"]))
                    $file = implode(":", $_POST["files"]);
                else
                    $file = "";

                Core::load("Mysql")->ins("Gallery", array("tag" => $_POST["name"], "files" => $file));
            } else if ($_POST["action"] == "edit-tag") {
                // implode files
                if (isset($_POST["files"]))
                    $file = implode(":", $_POST["files"]);
                else
                    $file = "";

                Core::load("Mysql")->upd("Gallery", $_POST["id"], array("files" => $file));
            } else if ($_POST["action"] == "upload") {
                if ($_FILES["file"]["error"] > 0) {
                    trigger_error("upload failed: ".$_FILES["file"]["error"]);
                } else {
                    if (file_exists("inc/".get_class($this)."/up/".$_FILES["file"]["name"])) {
                        trigger_error("file with this name already exists");
                    } else {
                        if (!is_writable("inc/".get_class($this)."/up")) {
                            trigger_error("upload folder is not writeable");
                        } else {
                            $dst = str_replace(" ", "-", $_FILES["file"]["name"]);
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], "inc/".get_class($this)."/up/".$dst) == false)
                                trigger_error("couldn't move uploaded file from temp folder");
                            $this->createThumbnail($dst);
                        }
                    }
                }
            } else if ($_POST["action"] == "remove-tag") {
                Core::load("Mysql")->del("Gallery", $_POST["id"]);
            } else if ($_POST["action"] == "remove-file") {
                if (file_exists("inc/".get_class($this)."/up/".$_POST["file"]))
                    unlink("inc/".get_class($this)."/up/".$_POST["file"]);
                if (file_exists("inc/".get_class($this)."/up/thumb/".$_POST["file"]))
                    unlink("inc/".get_class($this)."/up/thumb/".$_POST["file"]);
            } else {
                trigger_error("unknown action");
            }
        }

        return Core::inc("inc/".get_class($this)."/adminView.php", array("name" => get_class($this)));
    }

    /** create thumbnail
     *
     * this function tries to create a thumbnail with given filename
     * it fails if the extension is not recognized
     *
     * \param   $fn     filename
     */
    private function createThumbnail($fn) {
        // default width
        $desired_width = 150;

        // get extension
        $ext = pathinfo($fn, PATHINFO_EXTENSION);

        /* read the source image */
        if ($ext == "jpg" || $ext == "jpeg") {
            $source_image = imagecreatefromjpeg("inc/".get_class($this)."/up/".$fn);
        } else if ($ext == "png") {
            $source_image = imagecreatefrompng("inc/".get_class($this)."/up/".$fn);
        } else {
            trigger_error("unknown extension");
            return;
        }

        $width = imagesx($source_image);
        $height = imagesy($source_image);

        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height*($desired_width/$width));

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width,$desired_height);

        /* copy source image at a resized size */
        imagecopyresized($virtual_image,$source_image,0,0,0,0,$desired_width,$desired_height,$width,$height);

        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image,"inc/".get_class($this)."/up/thumb/".$fn, 83);
    }

    /** recreate all thumbnails
     *
     * this function deletes all thumbnails and invokes the 'createThumbnail()' 
     * function on each file in the 'up' folder.
     */
    private function recreateAllThumbnails() {
        // delete all thumbs
        foreach (scandir("inc/".get_class($this)."/up/thumb") as $f) {
            if ($f === "." || $f === "..") continue;
            unlink("inc/".get_class($this)."/up/thumb/".$f);
        }

        // recreate all thumbs
        foreach (scandir("inc/".get_class($this)."/up") as $f) {
            if ($f == "." || $f == ".." || $f == "thumb") continue;
            $this->createThumbnail($f);
        }
    }

    public function Ajax() {
        if (isset($_GET["action"])) {
            if ($_GET["action"] == "getFiles" && isset($_GET["id"])) {
                // get files
                $e = Core::load("", "Mysql")->sel("Gallery", array("id" => $_GET["id"]));
                $files = explode(":", $e[0]["files"]);

                $ret = "";
                foreach (scandir("inc/".get_class($this)."/up") as $f) {
                    if ($f == "." || $f == ".." || $f == "thumb") continue;
                    if (in_array($f, $files))
                        $ret .= '<option value="'.$f.'" selected="selected">'.$f."</option>\n";
                    else
                        $ret .= '<option value="'.$f.'">'.$f."</option>\n";
                }

                return $ret;
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
