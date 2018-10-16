<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	header('Content-type: text/html');
	if (!isset($_SESSION["login"]))
	{
		$_SESSION["login"] = "guest";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Index</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" description="mdilapi" />
		<meta charset="utf-8" />
		<?php require_once('./includes/main-includes.php'); ?>
	</head>
	<body onload="onReady()">
		<?php require_once('./includes/navbar.php'); ?>
		<?php require_once('./config/database.php');
				require_once('./includes/Element.php');
			$pdo = DB::getConnection();
			$stmt = $pdo->prepare("Select * FROM images LIMIT 10");
			$stmt->execute();
			$maindiv = new Element("div", false);
			$maindiv->add_class("row");
			$articles = array();
			while (($row = $stmt->fetch(PDO::FETCH_ASSOC)))
			{
				$trial = new Element("img", true);
				$trial->add_attribute("src", "data:image/jpg;base64,".base64_encode($row["src"]));
				$trial->add_attribute("id", $row["id"]);
				$trial->add_class("img-thumbnail");
				$trial->add_attribute("alt", "Random");
				$art = new Element("article", false);
				$head_div = new Element("header", false);
				$head_div->add_text($row["user_id"]);
				$art->add_child($head_div);
				$img_div = new Element("div", false);
				$img_div->add_class("img-wrapper");
				$img_div->add_child($trial);
				$art->add_child($img_div);
				$comm_div = new Element("div", false);
				$comm_div->add_class("comment_section");
				$heart_span = new Element("span", false);
				$heart_span->add_class("glyphicon glyphicon-heart-empty");
				$comm_div->add_child($heart_span);
				$art->add_child($comm_div);
				array_push($articles, $art);
			}
			foreach($articles as $key => $value)
			{
				$maindiv->add_child($value);
			}
			echo $maindiv;
		?>
		<?php require_once('./includes/footer.php'); ?>
	</body>
</html>