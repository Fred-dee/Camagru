<?php

if (!isset($_SESSION))
    session_start();
require_once('./includes/functions.php');
require_once('./config/database.php');
if ($_SESSION["login"] == "guest") {
    index_error(-1, "You must be logged in to view this page");
}
$pdo = DB::getConnection();
if (isset($_POST["images"]))
{
    $all = json_decode($_POST["images"]);

    $full_thing = imagecreatetruecolor(500, 375);
    imagealphablending($full_thing, true);
    imagesavealpha($full_thing, true);
    $fw = imagesx($full_thing);
    $fh = imagesy($full_thing);
    $org_aspect = $fw / $fh;
	$fail = false;
    foreach ($all as $key => $value)
	{

        $data = explode(",", $value, 2);
		$fresh = base64_decode($data[1]);

		$img = imagecreatefromstring($fresh);
        if($img !== false)
	   	{
			imagealphablending($img, true);
			imagesavealpha($img, true);
			$w = imagesx($img);
			$h = imagesy($img);
			if ($w / $h > $org_aspect)
				$w = $h*$org_aspect;
			else
				$h = $w/$org_aspect;
			$img = imagescale($img, $fw, -1);
			imagecopy($full_thing, $img, 0, 0, 0, 0, $w, imagesy($img));
		}
		else
			$fail = true;
    }
    try{
			if ($fail == false)
			{
				$imgdir = "./imgs/trial" . $_SESSION["user_id"] . ".png";
				imagepng($full_thing, $imgdir);
				$final_image = base64_encode(file_get_contents($imgdir));
				if (isset($_GET)) {
					if ($_GET["type"] == "propic") {
						$stmt = $pdo->prepare("UPDATE users SET `avatar`=:img, `type`='png'WHERE id=:uid");
						$stmt->bindParam(":img", $final_image, PDO::PARAM_STR);
						$stmt->bindParam(":uid", $_SESSION["user_id"]);
						$stmt->execute();
					} else {

						$stmt = $pdo->prepare("INSERT INTO `images` (`user_id`, `src`, `creation_date`, `type`) VALUES (:uid, :src, NOW(), 'png')");
						$stmt->bindParam(":uid", $_SESSION["user_id"], PDO::PARAM_INT);
						$stmt->bindParam(":src", $final_image, PDO::PARAM_STR);
						$stmt->execute();
					}
					imagedestroy($full_thing);
					unlink($imgdir);
					echo "success";
					exit();
				}
			}
			echo "failure";
		}
        
    catch (\PDOException $e) {
        echo $e->getMessage();
    }
}
else
{
    echo "Failure: Invalid Method/File";
}

?>
