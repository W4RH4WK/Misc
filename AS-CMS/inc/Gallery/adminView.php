<?php
    // get files
    $files = array();
    foreach (scandir("inc/".$data["name"]."/up") as $f) {
        if ($f == "." || $f == ".." || $f == "thumb") continue;
        $files[] = $f;
    }

    // get tags
    $tags = "";
    $res = Core::load("Mysql", "Mysql")->query("SELECT id, tag FROM Gallery ORDER BY tag");
    while ($row = $res->fetch_assoc())
        $tags[$row["id"]] = $row["tag"];
    $res->free();
?>

<div id="actions">
<a href="#modal-new-tag" class="btn btn-primary" data-toggle="modal"><i class="icon-file icon-white"></i> New Tag</a>
<a href="#modal-upload" class="btn btn-primary" data-toggle="modal"><i class="icon-upload icon-white"></i> Upload File</a>
<a href="?admin=<?php echo $data["name"]; ?>&amp;action=recreateThumbs" class="btn"><i class="icon-picture"></i> Recreate Thumbnails</a>
<a href="#modal-help" class="btn" data-toggle="modal"><i class="icon-question-sign"></i> Help</a>
</div>
<div class="row-fluid">
    <div class="span6">
        <h3>Tags</h3>
        <ul class="unstyled">
            <?php if (is_array($tags))
                    foreach($tags as $id => $tag) 
                            echo '<li><a href="#modal-edit-tag" data-toggle="modal" onclick="setFormEditTag('.$id.')">'.$tag."</a></li>\n";
            ?>
        </ul>
    </div>
    <div class="span6">
        <h3>Files</h3>
        <ul class="unstyled">
            <?php foreach($files as $f) 
                echo '<li><a href="#modal-remove-file" data-toggle="modal" onclick="setFormRemoveFile(\''.$f.'\')">'.$f."</a></li>\n";
            ?>
        </ul>
    </div>
</div>

<?php
    include("inc/".$data["name"]."/adminViewEditTag.php");
    include("inc/".$data["name"]."/adminViewHelp.php");
    include("inc/".$data["name"]."/adminViewNewTag.php");
    include("inc/".$data["name"]."/adminViewRemoveFile.php");
    include("inc/".$data["name"]."/adminViewUpload.php");
?>

<script type="text/javascript" src="inc/<?php echo $data["name"]; ?>/scripts.js"></script>
