<div class="modal hide fade" id="modal-new">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>New Admin</h3>
    </div>
    <form class="well form-horizontal" method="post">
        <fieldset>
            <input type="hidden" name="action" value="new" />
            <div class="modal-body">
                <div class="control-group">
                    <label class="control-label" for="form-new-user">Username</label>
                    <div class="controls">
                        <input type="text" name="user" id="form-new-user" />
                    </div>
                </div>
                <div class="control-group" id="form-new-control-pass">
                    <label class="control-label" for="form-new-pass">Password</label>
                    <div class="controls">
                        <input type="password" name="pass" id="form-new-pass" onchange="formNewPwChanged()" />
                        <input type="password" name="pass2" id="form-new-pass2" onchange="formNewPwChanged()" />
                        <br />
                        <p id="form-new-pass-help" class="help-block">Passwords doesn't match</p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="form-new-perm">Permissions</label>
                    <div class="controls">
                        <input type="text" name="perm" id="form-new-perm" />
                        <br />
                        <p class="help-block">use ":" to separat components, "*" gives access to all components</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><i class="icon-file icon-white"></i> Create</button>
                <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancel</a>
            </div>
        </fieldset>
    </form>
</div>

<script type="text/javascript">
    function formNewPwChanged() {
        if (document.getElementById("form-new-pass").value == document.getElementById("form-new-pass2").value) {
            document.getElementById("form-new-pass-help").style.display = "none";
            document.getElementById("form-new-control-pass").className  = "control-group";
        } else {
            document.getElementById("form-new-pass-help").style.display = "inline";
            document.getElementById("form-new-control-pass").className  = "control-group error";
        }
    }

    formNewPwChanged();
</script>
