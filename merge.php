<?php
if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
require_once('./config/database.php');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}
$pdo = DB::getConnection();
if(isset($_POST["images"]))
{
    $all = json_decode($_POST["images"]);
	
	//$full_thing = imagecreatetruecolor(500, 375);
	$first = array_shift($all);
	$data = explode(",", $first);
	$data[1] = base64_decode($data[1]);
	$full_thing =  imagecreatefromstring($data[1]);
	imagealphablending(full_thing , true);
	imagesavealpha(full_thing , true);
	$fw = imagesx($full_thing);
	$fh = imagesx($full_thing);
	//echo "The Width is: ".$fw." and the Height is: ".$fh;
	//ob_start();
	foreach($all as $key => $value)
	{

		$data = explode(",", $value);
		$data[1] = base64_decode($data[1]);
		$img =  imagecreatefromstring($data[1]);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		$w = imagesx($img);
		$h = imagesy($img);
		$img = imagescale($img, $fw, $fh, IMG_GAUSSIAN);
		$w = imagesx($img);
		$h = imagesy($img);
		//echo "The Width is: ".$w." and the Height is: ".$h;
		imagecopyresampled($full_thing, $img, 0, 0, 0, 0, $fw, $fh, $fw, $fh);
		
		
	}

	try
	{
		$imgdir = "./imgs/trial".$_SESSSION["user_id"].".png";
		imagepng($full_thing, $imgdir);
		$final_image = base64_encode(file_get_contents($imgdir));
		if(isset($_GET) && $_GET["type"] == "propic")
		{

			$stmt = $pdo->prepare("UPDATE users SET `avatar`=:img, `type`='png'WHERE id=:uid");
			$stmt->bindParam(":img", $final_image, PDO::PARAM_STR);
			$stmt->bindParam(":uid", $_SESSION["user_id"]);
			$stmt->execute();
		}
		else
		{
			$stmt = $pdo->prepare("INSERT INTO `images` (`user_id`, `src`, `creation_date`, `type`) VALUES (:uid, :src, NOW(), 'png')");
			$stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT);
			$stmt->bindParam(":src", $final_image, PDO::PARAM_STR);
			$stmt->execute();
		}
		imagedestroy($full_thing);
		unlink($imgdir);
		echo "success";
	}catch(\PDOException $e)
	{
		echo $e->getMessage();
	}
	//echo "success";
	//echo (base64_encode(file_get_contents($full_thing)));
}
else
{
	echo "Failure: Invalid Method/File";
}

/*
$width = 268;
$height = 300;
$MAX_SIZE = 100;
if($width > $MAX_SIZE || $height > $MAX_SIZE) {
    $aspect = $width / $height;
    if($width > $height) {
        $width = $MAX_SIZE;
        $height = intval($MAX_SIZE / $aspect);
    } else {
        $height = $MAX_SIZE;
        $width = intval($MAX_SIZE * $aspect);
    }
}
*/
?>
