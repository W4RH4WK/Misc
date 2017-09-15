<div class="modal hide fade" id="modal-edit-menu">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Edit Menu</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="edit-menu" />
        <div class="modal-body">
            <table>
                <tr>
                    <td width="100"><label>Id</label></td>
                    <td><input type="text" name="id" id="form-edit-menu-id" class="uneditable-input" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td><label>Label</label></td>
                    <td><input type="text" name="label" id="form-edit-menu-label" /></td>
                </tr>
                <tr>
                    <td><label>Parent</label></td>
                    <td>
                        <select name="parent" id="form-edit-menu-parent">
                            <option value="0"> - None - </option>
                            <?php printParentOptions(); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Sort</label></td>
                    <td><input type="text" name="sort" id="form-edit-menu-sort" /></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-edit icon-white"></i> Edit</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
