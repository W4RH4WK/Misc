<div class="modal hide fade" id="modal-remove-file">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Remove File</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="remove-file" />
        <input type="hidden" name="file" id="form-remove-file-file" />
        <div class="modal-body">
            <p>are you sure, you want to delete this file?</p>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger"><i class="icon-trash icon-white"></i> Remove</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
