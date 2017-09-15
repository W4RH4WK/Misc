<div class="modal hide fade" id="modal-edit">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Edit Entry</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="edit" />
        <div class="modal-body">
            <table>
                <tr>
                    <td width="200"><label>Id</label></td>
                    <td><input type="text" name="id" id="form-edit-id" class="uneditable-input" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td><label>Name</label></td>
                    <td><input type="text" name="name" id="form-edit-name" /></td>
                </tr> 
                <tr>
                    <td colspan="2"><textarea cols="80" rows="20" class="markItUp" name="text" id="form-edit-text"></textarea></td>
                </tr>
                <tr>
                    <td>Parse with Markdown</td>
                    <td><input type="checkbox" name="markdown" id="form-edit-markdown" /></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-edit icon-white"></i> Edit</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
