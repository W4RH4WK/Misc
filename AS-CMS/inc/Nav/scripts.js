function setFormRemoveMenu(id) {
    document.getElementById("form-remove-menu-id").value = id;
}

function setFormRemoveLink(id) {
    document.getElementById("form-remove-link-id").value = id;
}

function setFormEditMenu(id, label, parent, sort) {
    document.getElementById("form-edit-menu-id").value = id;
    document.getElementById("form-edit-menu-label").value = label;
    document.getElementById("form-edit-menu-sort").value = sort;

    // get element
    var e = document.getElementById("form-edit-menu-parent");

    // get index
    var index;
    for (var i = 0; i < e.options.length; i++) {
        if (e.options[i].value == parent) {
            index = e.options[i].index;
            break;
        }
    }

    // set form
    document.getElementById("form-edit-menu-parent").selectedIndex = index;
}

function setFormEditLink(id, menu, label, link, sort) {
    document.getElementById("form-edit-link-id").value = id;
    document.getElementById("form-edit-link-label").value = label;
    document.getElementById("form-edit-link-link").value = link;
    document.getElementById("form-edit-link-sort").value = sort;

    // get element
    var e = document.getElementById("form-edit-link-menu");

    // get index
    var index;
    for (var i = 0; i < e.options.length; i++) {
        if (e.options[i].value == menu) {
            index = e.options[i].index;
            break;
        }
    }

    // set form
    document.getElementById("form-edit-link-menu").selectedIndex = index;
}

function linkChanged() {
    if (document.getElementById("form-new-link-link-combobox0").selectedIndex == 0) {
        // show custom
        document.getElementById("form-new-link-link-text").style.display = "inline";
        document.getElementById("form-new-link-link-combobox1").style.display = "none";

    } else {
        // do ajax callout to fill combobox 1
        var from = document.getElementById("form-new-link-link-combobox0").options[document.getElementById("form-new-link-link-combobox0").selectedIndex].text;
        $("#form-new-link-link-combobox1").append("loading...").load("index.php?ajax=Nav&action=getEntries&c=" + from);

        // show combobox 1
        document.getElementById("form-new-link-link-text").style.display = "none";
        document.getElementById("form-new-link-link-combobox1").style.display = "inline";
    }
}

// init
linkChanged();
