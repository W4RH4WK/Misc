<div class="modal hide fade" id="modal-changePerm">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Change Permissions</h3>
    </div>
    <form class="well form-horizontal" method="post">
        <fieldset>
            <input type="hidden" name="action" value="changePerm" />
            <input type="hidden" name="id" id="form-changePerm-id" />
            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="form-changePerm-perm">Permissions</label>
                    <div class="controls">
                        <input type="text" name="perm" id="form-changePerm-perm" />
                        <br />
                        <p class="help-block">use ":" to separat components, "*" gives access to all components</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="icon-user icon-white"></i> Change</button>
                <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
            </div>
        </fieldset>
    </form>
</div>

<script type="text/javascript">
    function setFormChangePerm(id, perm) {
        document.getElementById("form-changePerm-id").value = id;
        document.getElementById("form-changePerm-perm").value = perm;
    }
</script>
