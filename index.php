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
		<div class="container-fluid" >
			<?php require_once('./config/database.php');
					require_once('./includes/Article.php');
					require_once('./includes/Element.php');
				$pdo = DB::getConnection();
				$stmt = $pdo->prepare("Select * FROM images LIMIT 10");
				$stmt->execute();
				$row_div = new Element("div", false);
				$body = array();

				$articles = array();
				while (($row = $stmt->fetch(PDO::FETCH_ASSOC)))
				{
					$inter = $pdo->prepare("Select user_name, avatar FROM users WHERE id = :user_id");
					$inter->bindParam(':user_id', $row["user_id"], PDO::PARAM_INT);
					$inter->execute();
					$uname = $inter->fetch(PDO::FETCH_ASSOC);
					$pro_pic;
					if ($uname["avatar"] == NULL)
						$pro_pic = "./imgs/avatar.png";
					else
						$pro_pic = "data:image/jpg;base64,".$uname["avatar"];
					$data = array(
						"img_src" => "data:image/jpg;base64,".base64_encode($row["src"]),
						"img_classes" => "img-thumbnail img-responsive",
						"img_id" => $row["id"],
						"user_id" => $uname["user_name"],
						"avatar_src" => $pro_pic,
					);
					$art = new Article($data);
					array_push($articles, $art);
				}
				foreach($articles as $key => $value)
				{
					$row_div = new Element("div", false);
					$row_div->add_class("row");
					$col_div = new Element("div", false);
					$col_div->add_class("col-xs-12");
					$col_div->add_child($value);
					$row_div->add_child($col_div);
					array_push($body, $row_div);
				}
				foreach($body as $key => $value)
				{
					echo $value;
				}
			?>
            <div class="pagination">
              <a href="#">&laquo;</a>
              <a href="#">1</a>
              <a href="#" class="active">2</a>
              <a href="#">3</a>
              <a href="#">4</a>
              <a href="#">5</a>
              <a href="#">6</a>
              <a href="#">&raquo;</a>
            </div>
		</div>
		<?php require_once('./includes/footer.php'); ?>
	</body>
</html>