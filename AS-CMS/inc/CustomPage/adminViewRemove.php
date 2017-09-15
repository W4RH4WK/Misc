<div class="modal hide fade" id="modal-remove">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Remove Entry</h3>
    </div>
    <form class="well" method="post">
        <input type="hidden" name="action" value="remove" />
        <input type="hidden" name="id" id="form-remove-id" />
        <div class="modal-body">
            really remove this entry?
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger"><i class="icon-trash icon-white"></i> Remove</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
