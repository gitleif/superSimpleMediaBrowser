<?php
// this file is used to create the mediaindexfile that is required
// in each folder that contains images..
require_once("supersimplemediabrowser.php");
require_once("innstillinger.php");

// if file data.php already exist in folder it will be overwritten.

$Folder = realpath(dirname(__FILE__)) . "/2019/";
echo("Created mediaindexfile data.php in folder : $Folder <br>");
$cls = new superSimpleMediaBrowser(null, null, null, null);
$cls->buildMediaDataFile($Folder, true);

$Folder = realpath(dirname(__FILE__)) . "/2018/";
echo("Created mediaindexfile data.php in folder : $Folder <br>");
$cls = new superSimpleMediaBrowser(null, null, null, null);
$cls->buildMediaDataFile($Folder, true);
?>