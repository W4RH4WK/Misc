<div class="modal hide fade" id="modal-new-menu">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>New Menu</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="new-menu" />
        <div class="modal-body">
            <table>
                <tr>
                    <td><label>Label</label></td>
                    <td><input type="text" name="label" id="form-new-menu-label" /></td>
                </tr>
                <tr>
                    <td><label>Parent</label></td>
                    <td>
                        <select name="parent" id="form-new-menu-parent">
                            <option value="0"> - None - </option>
                            <?php printParentOptions(); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Sort</label></td>
                    <td><input type="text" name="sort" id="form-new-menu-sort" /></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-file icon-white"></i> Create</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
