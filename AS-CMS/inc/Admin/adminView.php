<!-- show entries -->
<h2>Admin Users</h2>
<table class="table table-condensed well">
    <thead>
        <tr>
            <th>Id</th>
            <th>User</th>
            <th colspan="3">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data["entries"] as $e) { ?>
        <tr>
            <td><?php echo $e["id"]; ?></td>
            <td><?php echo $e["user"]; ?></td>
            <td>
                <a href="#modal-changePw" class="btn" data-toggle="modal" onclick="setFormChangePw(<?php echo $e["id"]; ?>)">
                    <i class="icon-user"></i> Password
                </a>
            </td>
            <td>
                <a href="#modal-changePerm" class="btn" data-toggle="modal" onclick="setFormChangePerm(<?php echo $e["id"]; ?>, '<?php echo $e["perm"]; ?>')">
                    <i class="icon-cog"></i> Permissions
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
    include("inc/".$data["name"]."/adminViewChangePerm.php");
    include("inc/".$data["name"]."/adminViewChangePw.php");
    include("inc/".$data["name"]."/adminViewHelp.php");
    include("inc/".$data["name"]."/adminViewNew.php");
    include("inc/".$data["name"]."/adminViewRemove.php");
?>
