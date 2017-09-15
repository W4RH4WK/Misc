<div class="modal hide fade" id="modal-edit-tag">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Edit Tag</h3>
    </div>
        <div class="modal-body">
            <form class="well" method="post">
                <input type="hidden" name="action" value="edit-tag" />
                <input type="hidden" name="id" id="form-edit-tag-id" />
                <select multiple="multiple" name="files[]" size="8" id="form-edit-tag-files">
                </select>
                <p>use CTRL to select multiple files</p>
                <button type="submit" class="btn btn-primary"><i class="icon-tags icon-white"></i> Edit</button>
            </form>

            <form class="well" method="post">
                <input type="hidden" name="action" value="remove-tag" />
                <input type="hidden" name="id" id="form-remove-tag-id" />
                <p>remove this tag</p>
                <button type="submit" class="btn btn-danger"><i class="icon-trash icon-white"></i> Remove</button>
            </form>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
