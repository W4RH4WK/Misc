function toggleSidemenu() {
    if (document.getElementById("navmenu").style.display == "none")
        // show
        document.getElementById("navmenu").style.display = "block";
    else
        // hide
        document.getElementById("navmenu").style.display = "none";
}

document.getElementById("navmenu").style.display = "none";
