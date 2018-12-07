<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_SESSION))
    session_start();
if($_SESSION["login"] == "guest")
    index_error(-1, "You must be logged in to view this page");
require_once('./config/database.php');
require_once('./includes/DIRS.php');
?>
<div class="row">
    <div class="col-md-12 center-av">
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
	<div class="col-md-12  center-form"> 
		<h1><?php echo $_SESSION["login"]?>'s profile</h1>
	</div>
	
    <div style="" class="col-md-12  center-op">

			<i class="fa fa-upload icon-large" aria-hidden="true"></i><a href="./capture?type=propic" class="links-dark">  Edit Profile Picture</a>
	 </div>
	
	<div style="" class="col-md-12  center-op">
		<i class="fa fa-window-close icon-large" aria-hidden="true"></i><a href="#" id="deleteProPic" class="links-dark">  Remove Profile Picture</a>
	</div>
	<div style="" class="col-md-12  center-op">
		<a class="nav-item links-dark" href="./forgot?reset=update">Change Password</a>
	</div>

</div>
