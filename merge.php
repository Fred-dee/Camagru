<?php
if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}

if(isset($_POST["mainImg"]) && isset($_POST["overlays"]))
{
    
}
?>
