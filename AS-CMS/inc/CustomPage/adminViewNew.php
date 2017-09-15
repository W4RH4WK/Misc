<div class="modal hide fade" id="modal-new">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>New Entry</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="new" />
        <div class="modal-body">
            <table>
                <tr>
                    <td width="200"><label>Name</label></td>
                    <td><input type="text" name="name" id="form-new-name" /></td>
                </tr>
                <tr> 
                    <td colspan="2"><textarea cols="80" rows="20" class="markItUp" name="text" id="form-new-text"></textarea></td>
                </tr>
                <tr>
                    <td>Parse with Markdown</td>
                    <td><input type="checkbox" name="markdown" id="form-new-markdown" /></td>
                </tr>
                <tr>
                    <td>Add to navigation</td>
                    <td><input type="checkbox" name="nav" id="form-new-nav" /></td>
                </tr>
                <tr>
                    <td>Add RSS feed</td>
                    <td><input type="checkbox" name="rss" id="form-new-rss" /></td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-file icon-white"></i> Create</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
