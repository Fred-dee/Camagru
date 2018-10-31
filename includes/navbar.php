<?php
if (!isset($_SESSION)) {
    session_start();
}
header('Content-type: text/html');
?>
<nav class="navbar navbar-dark grey darken-4 fixed-top scrolling-navbar">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="./index">Camagru</a>


        <!-- avatar or signin/login -->
        <?php
        /*
          TODO:
          find the avatar from the users database
         */
        require_once('./config/database.php');
        require_once('./includes/Element.php');
        require_once('./includes/functions.php');
        if (isset($_SESSION["login"])) {
            if ($_SESSION["login"] == "guest") {
                echo "<a class='nav-item nav-link' href='./login'>Login/Sign-up</a>";
            } else {
                $pdo = DB::getConnection();
                $stmt = $pdo->prepare("SELECT avatar FROM users WHERE user_name=:uname");
                $stmt->bindParam(':uname', $_SESSION["login"], PDO::PARAM_STR, 15);
                $stmt->execute();
                $val = $stmt->fetch(PDO::FETCH_ASSOC);
                $img = new Element("img", true);
                $img->add_class("avatar");
                $profile_link = new Element("a", false);
                $profile_link->add_attribute("href", "./profile");
                $profile_link->add_child($img);
                if ($val["avatar"] != null)
                    $img->add_attribute("src", "data:image/jpg;base64," . base64_encode($val["avatar"]));
                else
                    $img->add_attribute("src", "./imgs/avatar.png");
                $img->add_attribute("alt", "Avatar");
                $div = new Element("span", false);
                $div->add_class("navbar-right");
                $div->add_attribute("style", "display:inline-block; color: white; font: inherit");
                $h3 = new Element("h3", false);
                $h3->add_attribute("style", "display:inline-block; margin-right: 2px");
                $h3->add_text($_SESSION["login"]);
                $div->add_child($h3);
                $div->add_child($profile_link);
                $logout = new Element("a", false);
                $logout->add_class("nav-item");
                $logout->add_attribute("href", "./logout");
                $logout->add_text("Logout");
                $div->prepend_child($logout);
                echo $div;
            }
        }
        ?>
        <!-- /Avatar or signin/login -->
    <!-- Collapsible content -->
</nav>
