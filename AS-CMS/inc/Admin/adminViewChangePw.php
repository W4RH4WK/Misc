<div class="modal hide fade" id="modal-changePw">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Change Password</h3>
    </div>
    <form class="well form-horizontal" method="post">
        <fieldset>
            <input type="hidden" name="action" value="changePw" />
            <input type="hidden" name="id" id="form-changePw-id" />
            <div class="modal-body">
                <div class="control-group" id="form-changePw-control-pass">
                    <label class="control-label" for="form-changePw-pass">Password</label>
                    <div class="controls">
                        <input type="password" name="pass" id="form-changePw-pass" onchange="formChangePwChanged()" />
                        <input type="password" name="pass2" id="form-changePw-pass2" onchange="formChangePwChanged()" />
                        <br />
                        <p id="form-changePw-pass-help" class="help-block">Passwords doesn't match</p>
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
    function formChangePwChanged() {
        if (document.getElementById("form-changePw-pass").value == document.getElementById("form-changePw-pass2").value) {
            document.getElementById("form-changePw-pass-help").style.display = "none";
            document.getElementById("form-changePw-control-pass").className  = "control-group";
        } else {
            document.getElementById("form-changePw-pass-help").style.display = "inline";
            document.getElementById("form-changePw-control-pass").className  = "control-group error";
        }
    }

    function setFormChangePw(id) {
        document.getElementById("form-changePw-id").value = id;
    }

    formChangePwChanged();
</script>
