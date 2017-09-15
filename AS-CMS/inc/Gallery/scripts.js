function setFormRemoveFile(fn) {
    document.getElementById("form-remove-file-file").value = fn;
}

function setFormEditTag(id) {
    // ajax call for files
    $("#form-edit-tag-files").append("loading...").load("index.php?ajax=Gallery&action=getFiles&id=" + id);

    // set id
    document.getElementById("form-edit-tag-id").value = id;
    document.getElementById("form-remove-tag-id").value = id;
}

// setup tooltips
$("#files a").tooltip({placement:"bottom"});
