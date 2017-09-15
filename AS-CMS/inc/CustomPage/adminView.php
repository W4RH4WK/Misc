<!-- show entries -->
<h2>Custom Pages</h2>
<table class="table table-condensed well">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Using Markdown</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data["entries"] as $e) { ?>
        <tr>
            <td><?php echo $e["id"]; ?></td>
            <td><?php echo $e["name"]; ?></td>
            <td><?php echo $e["markdown"] == 0 ? "no" : "yes"; ?></td>
            <td>
                <a href="#modal-edit" class="btn" data-toggle="modal" onclick="setFormEdit(
                '<?php echo $e["id"]; ?>',
                '<?php echo $e["name"]; ?>',
                '<?php echo $e["markdown"]; ?>'
                    )"><i class="icon-edit"></i> Edit
                </a>
            </td>
            <td>
                <a href="#modal-remove" class="btn btn-danger" data-toggle="modal" onclick="setFormRemove(<?php echo $e["id"]; ?>)">
                    <i class="icon-trash icon-white"></i> Remove
                </a>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td>
                <a href="#modal-new" class="btn btn-primary" data-toggle="modal"><i class="icon-file icon-white"></i> New</a>
            </td>
            <td>
                <a href="#modal-help" class="btn" data-toggle="modal"><i class="icon-question-sign"></i> Help</a>
            </td>
        </tr>
    </tbody>
</table>

<?php
    include("inc/".$data["name"]."/adminViewEdit.php");
    include("inc/".$data["name"]."/adminViewHelp.php");
    include("inc/".$data["name"]."/adminViewNew.php");
    include("inc/".$data["name"]."/adminViewRemove.php");
?>

<script type="text/javascript" src="inc/<?php echo $data["name"]; ?>/scripts.js"></script>
