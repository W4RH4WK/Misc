<div class="modal hide fade" id="modal-upload">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Upload</h3>
    </div>
    <form class="well" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload" />
        <div class="modal-body">
            <input type="file" name="file" />
            <p>Currently only .jpg and .png are valid picture formats.</p>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="icon-upload icon-white"></i> Upload</button>
            <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
        </div>
    </form>
</div>
