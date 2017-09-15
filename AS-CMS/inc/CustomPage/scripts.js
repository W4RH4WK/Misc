function setFormEdit(id, name, markdown) {
    document.getElementById("form-edit-id").value = id;
    document.getElementById("form-edit-name").value = name;
    if (markdown == "0")
        document.getElementById("form-edit-markdown").checked = false;
    else 
        document.getElementById("form-edit-markdown").checked = true;

    // fill text
    $("#form-edit-text").html("loading...").load("index.php?ajax=CustomPage&action=getText&id=" + id);
}

function setFormRemove(id) {
    document.getElementById("form-remove-id").value = id;
}
