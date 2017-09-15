<div class="modal hide fade" id="modal-help">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Admin Component Help</h3>
    </div>
    <div class="modal-body">
        <p>This component is used to manage administrator users.</p>

        <h4>Id</h4>
        <blockquote>
            The id is used to identify every entry. It has to be unique and you
            don't need to care about it anyway. When a new entry is created,
            the database will automatically add a new id to your entry.
        </blockquote>

        <h4>User</h4>
        <blockquote>
            This is the username of the administrator.
        </blockquote>

        <h4>Password</h4>
        <blockquote>
            This is of course the password of the administrator user. When
            creating a new admin or changing the password of an existing admin,
            you need to enter enter the new password twice (in the two fields)
            to ensure that you typed it correctly.
        </blockquote>

        <h4>Permissions</h4>
        <blockquote>
            You can adjust the permissions of an admin by changing this entry.
            All components which should be accessable by this admin should be
            listed in this field using ":" as separator.
            <small>Admin:Navi</small>
            A wildcard "*" gives this admin access to <strong>all</strong> components.
            <small>*</small>
        </blockquote>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" data-dismiss="modal"><i class="icon-remove icon-white"></i> Close</a>
    </div>
</div>
