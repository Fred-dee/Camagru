<?php
header('Content-Type: text/html');
if(!isset($_SESSION))
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<titile>
			<?php
				require_once('./includes/functions.php');
				if (isset($_SESSION["login"]))
					echo $_SESSION["login"];
				else
				{
					index_error(-1, "You must be logged in to view this page");
				}
			?>

		</titile>
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
		</div>
		<?php
			require_once('./footer.php');
		?>
	</body>
</html>