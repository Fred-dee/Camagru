<?php

if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}
header('Content-Type: text/html');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit: <?php echo $_SESSION["login"]?></title>
        <?php
        require_once './includes/main-includes.php';
        ?>
    </head>
    <body>
        <?php
        require_once './includes/navbar.php';
        ?>
        <div class="container-fluid">
            
        </div>
        <?php
        require_once './includes/footer.php';
        ?>
    </body>
</html>
