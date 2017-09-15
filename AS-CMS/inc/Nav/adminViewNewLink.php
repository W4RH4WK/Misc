<?php
    // get runable components
    $runables = array();
    foreach (scandir("inc") as $f) {
        if ($f == "." || $f == "..") continue;
        if (Core::load("", $f) instanceof Runable)
            $runables[] = $f;
    }
?>
<div class="modal hide fade" id="modal-new-link">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>New Link</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="new-link" />
        <div class="modal-body">
            <table>
                <tr>
                    <td><label>Menu</label></td>
                    <td>
                        <select name="menu" id="form-new-link-menu">
                            <?php printMenuOptions($data["entries"]); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Label</label></td>
                    <td><input type="text" name="label" id="form-new-link-label" /></td>
                </tr>
                <tr>
                    <td><label>Link</label></td>
                    <td>
                        <select name="link-combobox0" id="form-new-link-link-combobox0" onchange="linkChanged()">
                            <option value="custom"> - Custom - </option>
                            <?php foreach ($runables as $f) {
                                echo "<option value=\"".$f."\">".$f."</option>\n";
                            } ?>
                        </select>
                        <select name="link-combobox1" id="form-new-link-link-combobox1">
                            <!-- filled via ajax -->
                        </select>
                        <input type="text" name="link-text" id="form-new-link-link-text" placeholder="custom link" />
                    </td>
                </tr>
                <tr>
                    <td><label>Sort</label></td>
                    <td><input type="text" name="sort" id="form-new-link-sort" /></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-file icon-white"></i> Create</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
