<?php
if (!isset($_SESSION)) {
    session_start();
}
header('Content-type: text/html');
?>
<nav class="navbar navbar-expand-lg navbar-dark grey darken-4 fixed-top scrolling-navbar">
    <!-- Navbar brand -->
    <a class="navbar-brand" href="./index">Camagru</a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
            aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content
    <div class="collapse navbar-collapse" id="basicExampleNav" toggle="true">

        <!-- Links 
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Features</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Pricing</a>
            </li>

            <!-- Dropdown 
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>

        </ul>
        <!-- Links -->
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
                $div->add_attribute("style", "display:inline-block");
                $h3 = new Element("h3", false);
                $h3->add_attribute("style", "display:inline-block; margin-right: 2px");
                $h3->add_text($_SESSION["login"]);
                $div->add_child($h3);
                $div->add_child($profile_link);

                echo $div;
            }
        }
        ?>
        <!-- /Avatar or signin/login -->
    </div>
    <!-- Collapsible content -->
</nav>
