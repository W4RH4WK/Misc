<div class="modal hide fade" id="modal-help">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">x</button>
        <h3>Navigation Component Help</h3>
    </div>
    <div class="modal-body">
        <p>This component is used to manage navigation entries dynamically.In
        order to do this, you need to provide some basic information to every
        entry.</p>

        <h4>Menus</h4>
        <blockquote>
            Menus are basic containers which can hold links and other menus
            (submenus). Currently this component only supports one level of
            submenus. A menu has it's own id, label and sort index.
        </blockquote>

        <h4>Menus Parent</h4>
        <blockquote>
            To create submenus, simple create a normal menu and set it's
            parent parameter to another menu.
        </blockquote>

        <h4>Links</h4>
        <blockquote>
            All links should be stored in menus and each link is definied by
            an id, the menu it belongs to, a label and the link itself and of
            course a sort index to adjust the order.
        </blockquote>

        <h4>Creating Entries</h4>
        <blockquote>
            First of all, make sure there is a menu you can add your link to.
            If not go a head and create a menu. Create a link afterwards and
            set the menu parameter to your newly created menu.
        </blockquote>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-primary" data-dismiss="modal"><i class="icon-remove icon-white"></i> Close</a>
    </div>
</div>
