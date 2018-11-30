<?php
if(!isset($_SESSION))
	session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../config/database.php");
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (isset($_POST["img_id"]))
	{
		try
		{
			$pdo = DB::getConnection();
			$stmt = $pdo->prepare("DELETE FROM images WHERE id=:iid");
			$stmt->bindParam(":iid", $_POST["img_id"], PDO::PARAM_INT);
			$stmt->execute();
			echo "Successfully removed image";
			//valid_success(1, "Succefully removed image.", "/profile");
		}
		catch(\PDOException $e)
		{
			echo "Could not delete image: ".$e->getMessage();
			//general_error(-1, "Could Not delete image: ".$e->getMessage(), "/profile");
		}
	}
	if(isset($_POST["action"]))
	{
		try
		{
			$pdo = DB::getConnection();
			$stmt = $pdo->prepare('UPDATE `users` SET `avatar`=NULL, `type`=NULL WHERE `user_name`=:uname');
			//$path = "./imgs/avatar.png";
			//$stmt->bindParam(":na", $path, PDO::PARAM_STR);
			$stmt->bindParam(":uname", $_SESSION["login"], PDO::PARAM_STR, 15);
			$stmt->execute();
			echo "success";
			
		}
		catch(\PDOException $e)
		{
			echo "Could not remove profile picture: ".$e->getMessage();
		}
	}
}
?>