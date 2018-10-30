<?php
    if(!isset($_SESSION))
        session_start();
    //if (!isset($_GET) && !isset($_POST))
    if(isset($_GET["uid"]))
    {
        if ($_SESSION["login"] != "guest")
            echo $_SESSION["user_id"];
        else
            echo "guest";
    }
?>
