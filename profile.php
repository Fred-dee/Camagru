<?php
header('Content-Type: text/html');
if (!isset($_SESSION))
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php
            require_once('./includes/functions.php');
            if (!isset($_SESSION["login"]) || $_SESSION["login"] == "guest") {
                index_error(-1, "You must be logged in to view this page");
            } else
                echo $_SESSION["login"];
            ?>

        </title>
        <?php
        require_once('./includes/main-includes.php');
        ?>
    </head>
    <body>
        <?php
        require_once('./includes/navbar.php');
        ?>
        <div class="container-fluid">
            <?php
            require_once('./includes/profile-head.php');
            ?>
            <hr/>
            <div class="row">
                <div class ="col-xs-12">
                    <?php
                    require_once("./includes/Element.php");
                    $div = new Element("div", false);
                    $msg;
                    $class;
                    if (isset($_SESSION["errors"])) {
                        $msg = $_SESSION["errors"]["errmsg"];
                        $class = "alert alert-danger";
                    }
                    if (isset($_SESSION["success"])) {
                        $msg = $_SESSION["success"]["message"];
                        $class = "alert alert-success";
                    }
                    if (isset($_SESSION["errors"]) || isset($_SESSION["success"])) {
                        $div->add_class($class);
                        $div->add_text($msg);
                        echo $div;
                        unset($_SESSION["errors"]);
                        unset($_SESSION["success"]);
                    }
                    ?>
                </div>
            </div>
            <?php
            require_once('./config/database.php');
            require_once('./includes/Article.php');
            require_once('./includes/Element.php');

            $pdo = DB::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name=:uname");
            $stmt->bindParam(":uname", $_SESSION["login"], PDO::PARAM_STR, 15);
            if (($result = $stmt->execute())) {
                $form = new Element("form", false);
                $form->add_attribute("method", "post");
                $form->add_attribute("action", "./private/update");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                foreach ($row as $key => $value) {
                    if ($key != "hash" && $key != "avatar" && $key != "id" && $key != "user_name" && $key != "type") {
                        $fg = new Element("div", false);
                        $fg->add_class("form-group");
                        $lb = new Element("label", false);
                        $lb->add_attribute("for", $key);
                        $lb->add_text($key . ":");
                        $ip = new Element("input", true);
                        $ip->add_class("form-control");
                        $ip->add_attribute("name", $key);
                        if ($key != "email")
                            $ip->add_attribute("type", "text");
                        else
                            $ip->add_attribute("type", "email");
                        $ip->add_attribute("value", $value);
                        $fg->add_child($lb);
                        $fg->add_child($ip);
                        $form->add_child($fg);
                    }
                }
                $btn = new Element("button", false);
                $btn->add_class("btn btn-primary grey darken-4 form-control");
                $btn->add_text("Update");
                $btn->add_attribute("type", "submit");
                $btn->add_attribute("name", "submit");
                $form->add_child($btn);
                echo $form;
                echo "<hr/>";
            }
            $stmt = $pdo->prepare("Select * FROM images WHERE user_id=:uname");
            $stmt->bindParam(":uname", $_SESSION["user_id"], PDO::PARAM_STR);
            $stmt->execute();
            $row_div = new Element("div", false);
            $body = array();

            $articles = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
                $inter = $pdo->prepare("Select user_name, avatar FROM users WHERE id = :user_id");
                $inter->bindParam(':user_id', $row["user_id"], PDO::PARAM_INT);
                $inter->execute();
                $uname = $inter->fetch(PDO::FETCH_ASSOC);
                $pro_pic;
                if ($uname["avatar"] == NULL)
                    $pro_pic = "./imgs/avatar.png";
                else
                    $pro_pic = "data:image/" . $uname["type"] . ";base64," . $uname["avatar"];
                $data = array(
                    "img_src" => "data:image/".$row["type"].";base64," .$row["src"],
                    "img_classes" => "img-thumbnail img-responsive",
                    "img_id" => $row["id"],
                    "user_id" => $uname["user_name"],
                    "avatar_src" => $pro_pic,
                );
                $art = new Article($data);
                $art->add_attribute("id", $row["id"] . "art");
                array_push($articles, $art);
            }
            $row_div = new Element("div", false);
            $row_div->add_class("gal-grid-thirds");
            foreach ($articles as $key => $value) {

                $col_div = new Element("div", false);
                $col_div->add_class("gal-col");
                $col_div->add_child($value);
                $row_div->add_child($col_div);
            }
            array_push($body, $row_div);
            foreach ($body as $key => $value) {
                echo $value;
            }
            ?>

        </div>
        <?php
        require_once('./includes/footer.php');
        ?>
    </body>
</html>