<div class="modal hide fade" id="modal-edit-link">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Edit Link</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="edit-link" />
        <div class="modal-body">
            <table>
                <tr>
                    <td width="100"><label>Id</label></td>
                    <td><input type="text" name="id" id="form-edit-link-id" class="uneditable-input" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td><label>Menu</label></td>
                    <td>
                        <select name="menu" id="form-edit-link-menu">
                            <?php printMenuOptions($data["entries"]); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Label</label></td>
                    <td><input type="text" name="label" id="form-edit-link-label" /></td>
                </tr>
                <tr>
                    <td><label>Link</label></td>
                    <td><input type="text" name="link" id="form-edit-link-link" /></td>
                </tr>
                <tr>
                    <td><label>Sort</label></td>
                    <td><input type="text" name="sort" id="form-edit-link-sort" /></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-edit icon-white"></i> Edit</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
