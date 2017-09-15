<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>markItUp! preview template</title>
<style type="text/css">
body {
    background-color: #EFEFEF;
    font: 70% Verdana, Arial, Helvetica, san-serif;
}
</style>
</head>
<body>
<?php
require_once("../markdown/markdown.php");
echo Markdown($_POST["data"]);
?>
</body>
</html>
