<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('./includes/Article.php');
require_once('./includes/Element.php');
require_once('./config/database.php');
header('Content-type: text/html');
if (!isset($_SESSION["login"])) {
    $_SESSION["login"] = "guest";
}
$_SESSION["getData"] = -1;
$_SESSION["returnNull"] = false;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Index</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" description="mdilapi" />
        <meta charset="utf-8" />
        <?php require_once('./includes/main-includes.php'); ?>
		<link rel="stylesheet" href="./css/gallery.css" type="text/css"/>
        <script src="js/likes.js"></script>
        <script src="./js/infintescroll.js"></script>
    </head>
    <body onload="onReady()">
        <?php require_once('./includes/navbar.php'); ?>
        <div class="container-fluid" >
            <?php
            output_returns();
            ?>

            <?php
            $body = getData();
            
            foreach($body as $key => $value)
                echo $value;
            ?>

        </div>
            <?php require_once('./includes/footer.php'); ?>
    </body>
</html>