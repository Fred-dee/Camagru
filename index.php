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
        <!--<script src="js/capture.js"></script> -->
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
            echo $_SESSION["getData"];
/*            $pdo = DB::getConnection();
            $pageno = 0;
            if (isset($_GET["page"])) {
                $pageno = intval(htmlspecialchars($_GET["page"]));
            }
            $pageno = 6 * $pageno;
            $stmt = $pdo->prepare("Select * FROM images LIMIT 6 OFFSET :off");
            $stmt->bindParam(':off', $pageno, PDO::PARAM_INT);
            $stmt->execute();
            $row_div = new Element("div", false);
            $body = array();
            $counter = 0;
            $articles = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
                $inter = $pdo->prepare("Select user_name, avatar, type FROM users WHERE id = :user_id");
                $inter->bindParam(':user_id', $row["user_id"], PDO::PARAM_INT);
                $inter->execute();
                $uname = $inter->fetch(PDO::FETCH_ASSOC);
                $pro_pic;
                if ($uname["avatar"] == NULL)
                    $pro_pic = "./imgs/avatar.png";
                else
                    $pro_pic = "data:image/" . $uname["type"] . ";base64," . $uname["avatar"];
                $data = array(
                    "img_src" => "data:image/" . $row["type"] . ";base64," . $row["src"],
                    "img_classes" => "img-thumbnail img-responsive",
                    "img_id" => $row["id"],
                    "user_id" => $uname["user_name"],
                    "avatar_src" => $pro_pic,
                );
                $art = new Article($data);
                $art->add_attribute("id", $row["id"] . "art");
                array_push($articles, $art);
            }
            foreach ($articles as $key => $value) {
                if ($counter == 0) {
                    $row_div = new Element("div", false);
                    $row_div->add_class("gal-grid-thirds");
                }

                $col_div = new Element("div", false);
                $col_div->add_class("gal-col");
                $col_div->add_child($value);
                $row_div->add_child($col_div);
                if ($counter == 2) {
                    array_push($body, $row_div);
                    $counter = -1;
                }
                $counter++;
            }
            array_push($body, $row_div);
            foreach ($body as $key => $value) {
                echo $value;
            }*/
            ?>

        </div>
            <?php require_once('./includes/footer.php'); ?>
    </body>
</html>