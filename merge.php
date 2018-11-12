<?php
if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}
if(isset($_POST["images"]))
{
    $all = json_decode($_POST["images"]);
	$full_thing = imagecreatetruecolor(500, 375);
	imagealphablending($full_thing, true);
	foreach($all as $key => $value)
	{

			$data = explode(",", $value);
			$data[1] = base64_decode($data[1]);
			$img =  imagecreatefromstring($data[1]);
			imagealphablending($img, true);
			
			imagecopy($full_thing, $img, 0, 0, 0, 0, 500, 375);
	}
}
?>
