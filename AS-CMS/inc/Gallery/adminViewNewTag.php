<div class="modal hide fade" id="modal-new-tag">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>New Tag</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="new-tag" />
        <div class="modal-body">
            <table>
                <tr>
                    <td valign="top" width="100"><label>Name</label></td>
                    <td><input type="text" name="name" id="form-new-tag-name" /></td>
                </tr>
                <tr>
                    <td valign="top"><label>Files</label></td>
                    <td>
                        <select multiple="multiple" name="files[]" size="12">
                            <?php foreach (scandir("inc/".$data["name"]."/up") as $f) {
                                if ($f == "." || $f == ".." || $f == "thumb") continue;
                                echo '<option value="'.$f.'">'.$f."</option>\n";
                            } ?>
                        </select>
                        <p>use CTRL to select multiple files</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-file icon-white"></i> Create</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
