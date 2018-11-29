<?php
if (!isset($_SESSION))
    session_start();
if ($_SESSION["login"] != "guest")
{
    header("location: ./index");
    exit();
}
if (isset($_GET["autok"]))
{

}
header('Content-type: text/html');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login/Sign-up</title>
        <?php require_once('./includes/main-includes.php'); ?>
        <script src="./js/login.js" type="text/javascript"></script>
    </head>
    <body class="container-fluid">
        <div class="row">
            <?php require_once('./includes/navbar.php'); ?>
        </div>
		<!--<div class="row">
			<div class="alert alert-success" style="width:100%; position:fixed; z-index:500">I can do this</div>
		</div> -->
        <div class="row" >
			<!--col-md-6 col-lg-offset-1 col-lg-5-->
            <div class ="col-xs-12 col-md-offset-1 col-md-5 col-lg-offset col-lg-5">
                <h1>Login</h1>
                <form method="post" action="./private/login_check" id ="form_login">
                    <div class="form-group">
                        <label for="lusername">Username/email</label>
                        <input class= "form-control"type="text" name="lusername" required />
                    </div>
                    <div class="form-group">
                        <label for="lpassword">Password:</label>
                        <input class="form-control" type="password" name="lpassword" required />
                    </div>
                    <input class="form-control btn btn-primary" name="submit" type="submit" value="Login" />
                </form>
                <a href="./forgot?reset=forgot" name="forgot_link">Forgot Password?</a>
                <?php
                if (isset($_SESSION["errors"])) {
                    if ($_SESSION["errors"]["errno"] == 0) {
                        echo "<div class='alert alert-danger'>" . $_SESSION["errors"]["errmsg"] . "</div>";
                        unset($_SESSION["errors"]);
                    }
                }
                ?>
            </div>

            <div class="col-xs-12 col-md-5">
                <h1>Sign up</h1>
                <form method="POST" action="./private/login_check" id="form_register">
                    <div class="form-group">
                        <label for="s_fname">First Name:</label>
                        <input class="form-control" type="text" name="s_fname" id="s_fname" required />
                    </div>
                    <div class="form-group">
                        <label for="s_lname">Last Name:</label>
                        <input class="form-control" type="text" name="s_lname" id="s_lname" required />
                    </div>
                    <div class="form-group">
                        <label for="s_username">User Name:</label>
                        <input class="form-control" type="text" name="s_username" id="s_username" required minlength="4"/>
                    </div>
                    <div class="form-group">
                        <label for="s_email">Email:</label>
                        <input class="form-control" type="email" name="s_email" id="s_email" required />
                    </div>
                    <div class="form-group">
                        <label for="s_password">Password:</label>
                        <input class="form-control" type="password" name="s_password" id="s_password" required />
                    </div>
                    <div class="form-group">
                        <label for="s_password">Confirm Password:</label>
                        <input class="form-control" type="password" name="s_cpassword" id="s_cpassword" required />
                    </div>
                    <input class="form-control btn btn-primary" name="submit" type="submit" value="Register" />
                </form>
                <?php
                if (isset($_SESSION["errors"])) {
                    if ($_SESSION["errors"]["errno"] == 1) {
                        echo "<div class='alert alert-danger'>" . $_SESSION["errors"]["errmsg"] . "</div>";
                        unset($_SESSION["errors"]);
                    }
                }
                ?>
            </div>
        </div>
        <?php require_once('./includes/footer.php'); ?>
    </body>
</html>