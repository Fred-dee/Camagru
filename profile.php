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
            <?php
            require_once('./config/database.php');
            require_once('./includes/Article.php');
            require_once('./includes/Element.php');

            $pdo = DB::getConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name=:uname");
            $stmt->bindParam(":uname", $_SESSION["login"], PDO::PARAM_STR, 15);
            if(($result = $stmt->execute()))
            {
                $form = new Element("form", false);
                $form->add_attribute("method", "post");
                $form->add_attribute("action", "./private/update");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                foreach($row as $key => $value)
                {
                    if ($key != "hash" && $key != "avatar" && $key != "id" && $key != "user_name")
                    {
                        $fg = new Element("div", false);
                        $fg->add_class("form-group");
                        $lb = new Element("label", false);
                        $lb->add_attribute("for", $key);
                        $lb->add_text($key.":");
                        $ip = new Element("input", true);
                        $ip->add_class("form-control");
                        $ip->add_attribute("name", $key);
                        $ip->add_attribute("type", "text");
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
            }
            ?>

        </div>
        <?php
        require_once('./includes/footer.php');
        ?>
    </body>
</html>