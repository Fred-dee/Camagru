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
	$full_thing = imagecreatetruecolor(500, 375);
	imagealphablending($full_thing, true);
	//ob_start();
	imagesavealpha($full_thing, true);
	foreach($all as $key => $value)
	{

		$data = explode(",", $value);
		$data[1] = base64_decode($data[1]);
		$img =  imagecreatefromstring($data[1]);
		imagealphablending($img, true);
		imagesavealpha($img, true);
		imagecopyresampled($full_thing, $img, 0, 0, 0, 0, 500, 375, 500, 375);
		
	}
	imagepng($full_thing, "./imgs/trial.png");
	//echo '<img src="data:image/jpg;base64,'.base64_encode(file_get_contents($full_thing)).'" />';
	echo file_exists("./imgs/trial.png");
	//echo (base64_encode(file_get_contents($full_thing)));
}
?>
