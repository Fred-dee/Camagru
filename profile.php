<?php
header('Content-Type: text/html');
if (!isset($_SESSION))
    session_start();
require_once('./config/database.php');
require_once('./includes/Article.php');
require_once('./includes/Element.php');
$_SESSION["getData"] = -1;
$_SESSION["returnNull"] = false;
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
		<script type="text/javascript" src="./js/profile.js"></script>
		<script type ="text/javascript" src="./js/infintescroll.js"></script>
		<script type="text/javascript" src ="./js/likes.js"></script> 
		<link type="text/css" rel="stylesheet" href="./css/gallery.css">
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
 			<?php output_returns(); ?>
            <?php


            $pdo = DB::getConnection();
			/*START PROGILE HEAD INFORMATION*/
            $stmt = $pdo->prepare("SELECT "
                    . "`user_name` AS `Username`, `first_name` AS `First Name`, `last_name` AS `Last Name`,  `email` as `Email Address`, em_subs  FROM users WHERE user_name=:uname");
            $stmt->bindParam(":uname", $_SESSION["login"], PDO::PARAM_STR, 15);
            if (($result = $stmt->execute())) {
                $form = new Element("form", false);
                $form->add_attribute("method", "post");
                $form->add_attribute("action", "./private/update");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                foreach ($row as $key => $value) {
                    if ($key != "hash" && $key != "avatar" && $key != "id" && $key != "user_name" && $key != "type" && $key != "em_subs" && $key != "verified" && $key != "verification_key") {
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
                    if($key == "em_subs")
                    {
                        $fg = new Element("div", false);
                        $fg->add_class("form-check");
                        $lb = new Element("label", false);
                        $lb->add_attribute("for", $key);
                        $lb->add_text("Receive email notifications");
                        $lb->add_class("form-check-label");
                        $ip =  new Element("input", true);
                        $ip->add_class("form-check-input");
                        $ip->add_attribute("name", $key);
                        $ip->add_attribute("type", "checkbox");
                        $ip->add_attribute("value", $value);
                        if($value == 1)
                            $ip->add_inlineattr("checked");
                        $fg->add_child($ip);
                        $fg->add_child($lb);
                        $form->add_child($fg);
                    }
                }
                $btn = new Element("button", false);
                $btn->add_class("btn btn-primary grey darken-4 form-control");
                $btn->add_text("Update");
                $btn->add_attribute("type", "submit");
                $btn->add_attribute("name", "submit");
                $form->add_child($btn);
				$row = new Element("div", false);
				//$col = new Element("div", false);
				
				
				$row->add_class("center-form");
				//$col->add_class("");
				
				
				$row->add_child($form);
				$form->add_attribute("style", "width:400px");
				//$col->add_child($form);
                echo $row;
                echo "<hr/>";
            }
			$body = getData(true);
            
            foreach($body as $key => $value)
                echo $value;
			/*END PROFILE HEAD FORM*/
			
/*		
            $stmt = $pdo->prepare("Select * FROM images WHERE user_id=:uname");
            $stmt->bindParam(":uname", $_SESSION["user_id"], PDO::PARAM_STR);
            $stmt->execute();
            $row_div = new Element("div", false);
            $body = array();

            $articles = array();
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
                $inter = $pdo->prepare("Select user_name, avatar, type FROM users WHERE id = :user_id");
                $inter->bindParam(':user_id', $row["user_id"], PDO::PARAM_INT);
                $inter->execute();
                $uname = $inter->fetch(PDO::FETCH_ASSOC);
                $pro_pic;
                if ($uname["avatar"] == NULL)
                {
                    $pro_pic = "./imgs/avatar.png";
                }
                else
                {
                    $pro_pic = "data:image/" . $uname["type"] . ";base64," . $uname["avatar"];
                }
                $data = array(
                    "img_src" => "data:image/".$row["type"].";base64," .$row["src"],
                    "img_classes" => "img-thumbnail img-responsive",
                    "img_id" => $row["id"],
                    "user_id" => $uname["user_name"],
                    "avatar_src" => $pro_pic,
                );
                $art = new Article($data);
				$btn_del =  new Element("button", false);
				$btn_del->add_text("Delete");
				$arr = array (
					"class" => "btn btn-primary grey darken-4 delete-par",
				);
				$btn_del->add_attributes($arr);
				$art->add_child($btn_del);
                $art->add_attribute("id", $row["id"] . "art");
                array_push($articles, $art);
            }
            $counter = 0;
            foreach ($articles as $key => $value) {
            if ($counter == 0)
            {
                $row_div = new Element("div", false);
                $row_div->add_class("gal-grid-thirds");
            }

            $col_div = new Element("div", false);
            $col_div->add_class("gal-col");
            $col_div->add_child($value);
            $row_div->add_child($col_div);
            if($counter == 2)
            {
                array_push($body, $row_div);
                $counter = -1;
            }
            $counter++;
        }
        array_push($body, $row_div);
		foreach ($body as $key => $value) {
                echo $value;
            }
			*/
            ?>

        </div>
        <?php
        require_once('./includes/footer.php');
        ?>
    </body>
</html>