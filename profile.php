<?php
header('Content-Type: text/html');
if(!isset($_SESSION))
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
				require_once('./includes/functions.php');
				if (!isset($_SESSION["login"]) || $_SESSION["login"] == "guest")
				{
					index_error(-1, "You must be logged in to view this page");
				}
                else
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
				require_once('./config/database.php');
				require_once('./includes/Article.php');
				require_once('./includes/Element.php');
				
				$pdo = DB::getConnection();
				
			?>
            <div class="row">
                <div class="col-md-offset-1 col-md-3">
                    <img class="avatar-lg img-responsive" src="./imgs/avatar.png" alt=""/>
                </div>
                <div class="col-md-6">
                    <h1>Fred-Dee</h1>
                    <br/>
                    <span>
                        <i class="fa fa-cog" aria-hidden="true"></i> <h3 style="display: inline-block">Edit Profile</h3></span>
                    <br/>
                    <i class="fa fa-upload" aria-hidden="true"></i><h3 style="display:inline-block">Upload Profile Picture</h3>
                </div>
            </div>
		</div>
		<?php
			require_once('./footer.php');
		?>
	</body>
</html>