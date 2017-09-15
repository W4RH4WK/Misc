<?php

function printMenu($menu, $indent) {
    echo "<tr class=\"menu\">\n";
    echo "<td style=\"padding-left: ".(string) ($indent * 20 + 5)."px;\">".$menu->label."</td>\n";
    echo "<td>Menu</td>\n";
    echo "<td>".$menu->id."</td>\n";
    echo "<td>".$menu->sort."</td>\n";
    echo "<td><a href=\"#modal-edit-menu\" data-toggle=\"modal\" onclick=\"setFormEditMenu('".$menu->id."', '".$menu->label."', '".$menu->parent."', '".$menu->sort."')\">edit</a></td>\n";
    echo "<td><a href=\"#modal-remove-menu\" data-toggle=\"modal\" onclick=\"setFormRemoveMenu('".$menu->id."')\">remove</a></td>\n";
    echo "</tr>\n";
}

function printLink($link, $indent) {
    echo "<tr class=\"link\">\n";
    echo "<td style=\"padding-left: ".(string) ($indent * 20 + 5)."px;\">".$link->label."</td>\n";
    echo "<td>Link</td>\n";
    echo "<td>".$link->id."</td>\n";
    echo "<td>".$link->sort."</td>\n";
    echo "<td><a href=\"#modal-edit-link\" data-toggle=\"modal\" onclick=\"setFormEditLink('".$link->id."', '".$link->menu."', '".$link->label."', '".$link->link."', '".$link->sort."')\">edit</a></td>\n";
    echo "<td><a href=\"#modal-remove-link\" data-toggle=\"modal\" onclick=\"setFormRemoveLink('".$link->id."')\">remove</a></td>\n";
    echo "</tr>\n";
}

function printEntries($entries, $rc=0) {
    foreach ($entries as $e) {
        if ($e instanceof NavMenu) {
            printMenu($e, $rc);
            printEntries($e->storage, $rc + 1);
        } else {
            printLink($e, $rc);
        }
    }
}

function printMenuOptions($entries) {
    foreach ($entries as $e) {
        if ($e instanceof NavMenu) {
            echo "<option value=\"".$e->id."\">".$e->label."</option>\n";
            printMenuOptions($e->storage);
        }
    }
}

function printParentOptions() {
    foreach (Core::load("Mysq", "Mysql")->sel("NavMenu", array("parent" => 0)) as $m)
        echo "<option value=\"".$m["id"]."\">".$m["label"]."</option>\n";
}

?>
<!-- build the entries table -->
<table class="table table-condensed well NavEntries">
    <thead>
        <tr>
            <th width="30%">Label</th>
            <th>Type</th>
            <th>Id</th>
            <th>Sort</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php printEntries($data["entries"]); ?>
        <tr>
            <td colspan="4">&nbsp;</td>
            <td><a href="#modal-new-link" class="btn btn-primary" data-toggle="modal"><i class="icon-file icon-white"></i> New Link</a></td>
            <td><a href="#modal-new-menu" class="btn btn-primary" data-toggle="modal"><i class="icon-file icon-white"></i> New Menu</a></td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
            <td><a href="#modal-help" class="btn" data-toggle="modal"><i class="icon-question-sign"></i> Help</a></td>
        </tr>
    </body>
</table>

<?php
    include("inc/".$data["name"]."/adminViewEditLink.php");
    include("inc/".$data["name"]."/adminViewEditMenu.php");
    include("inc/".$data["name"]."/adminViewHelp.php");
    include("inc/".$data["name"]."/adminViewNewLink.php");
    include("inc/".$data["name"]."/adminViewNewMenu.php");
    include("inc/".$data["name"]."/adminViewRemoveLink.php");
    include("inc/".$data["name"]."/adminViewRemoveMenu.php");
?>

<script type="text/javascript" src="inc/<?php echo $data["name"]; ?>/scripts.js"></script>
