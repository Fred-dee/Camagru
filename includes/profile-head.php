<?php 
if(!isset($_SESSION))
    session_start();
if($_SESSION["login"] == "guest")
    index_error(-1, "You must be logged in to view this page");
include_once('../config/database.php');
include_once('./DIRS.php');
?>
<div class="row">
    <div class="col-md-offset-1 col-md-3">
        <?php
                $pdo = DB::getConnection();
                $stmt = $pdo->prepare("SELECT avatar, type FROM users WHERE user_name=:uname");
                $stmt->bindParam(':uname', $_SESSION["login"], PDO::PARAM_STR, 15);
                $stmt->execute();
                $val = $stmt->fetch(PDO::FETCH_ASSOC);
                $img = new Element("img", true);
                $img->add_class("avatar-lg img-responsive");
                if ($val["avatar"] != null)
                    $img->add_attribute("src", "data:image/".$val["type"].";base64," . ($val["avatar"]));
                else
                    $img->add_attribute("src", "./imgs/avatar.png");
                echo $img;
        ?>
        <!--<img class="avatar-lg img-responsive" src="./imgs/avatar.png" alt=""/> -->
    </div>
    <div class="col-md-6">
        <h1><?php echo $_SESSION["login"]?></h1>
        <br/>
        <br/>
        <i class="fa fa-upload icon-large" aria-hidden="true"></i><h3 style="display:inline-block"><a class="nav-link" href="./capture?type=propic">Edit Profile Picture</a></h3>
    </div>
</div>
