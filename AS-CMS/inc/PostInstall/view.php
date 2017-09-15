<form class="well" method="post">
    <input type="hidden" name="action" value="install" />
    <select name="component">
    <?php foreach (scandir("inc") as $f) {
        if ($f == "." || $f == "..") continue;
         $c = Core::load("", $f);
         if ($c instanceof Installable)
         echo '<option value="'.$f.'">'.$f.'</option>';
    } ?>
    </select><br />
    <button type="submit" class="btn btn-primary"><i class="icon-wrench icon-white"></i> Install</button>
</form>
