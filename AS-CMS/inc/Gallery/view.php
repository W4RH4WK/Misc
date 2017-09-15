<h1><?php echo $data["tag"]; ?></h1>
<hr />

<div class="row-fluid">
    <div class="span2">
        <ul class="unstyled" id="tags">
            <li><a href="?run=<?php echo $data["name"]; ?>">All</a></li>
            <?php foreach($data["tags"] as $t)
                echo '<li><a href="?run='.$data["name"].'&amp;tag='.$t.'">'.$t."</a></li>\n";
            ?>
        </ul>
    </div>
    <div class="span10" id="files">
        <?php foreach($data["files"] as $f)
            echo '<a href="inc/'.$data["name"].'/up/'.$f.'" rel="lightbox[gallery]" title="'.$f.'" rel="tooltip" data-original-title="'.$f.'"><img src="inc/'.$data["name"].'/up/thumb/'.$f."\" /></a>\n";
        ?>
    </div>
</div>

<script type="text/javascript" src="inc/<?php echo $data["name"]; ?>/scripts.js"></script>
