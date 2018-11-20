<?php
if (!isset($_SESSION))
	session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../config/database.php');
require_once('../includes/functions.php');

if ($_SERVER["REQUEST_METHOD"] == "GET")
{
	$link = $_GET["bar"];
	$split = preg_split("/delimiter/", base64_decode($link));
	
	$uname = $split[0];
	$key = $split[1];
	
	
	try
	{
		$pdo = DB::getConnection();
		$stmt = $pdo->prepare("SELECT `verification_key`, `id` FROM `users` WHERE user_name =:uid");
		$stmt->bindParam(":uid", $uname, PDO::PARAM_STR, 15);
		$stmt->execute();
		if ($stmt->rowCount() == 1)
		{
			$res = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($res["verification_key"] == $key)
			{
				$_SESSION["login"] = $uname;
				$_SESSION["user_id"] = (int) $res["id"];
				
				$stmt = $pdo->prepare("UPDATE `users` SET `verified`=1 WHERE user_name = :uname");
				$stmt->bindParam(":uname", $uname, PDO::PARAM_STR, 15);
				$stmt->execute();
				valid_success(1, "Account Succesfully Activated", "/index");
			}
			else
				general_error(-1, "Invalid Activation URL: ".$uname." ".$key, "/index");
		}
		else
			general_error(-1, "Invalid Activation URL", "/index");

	}
	catch (\PDOException $e)
	{
		general_error(-1, "Could not activate account: ".$e->getMessage(), "/index");
	}
}
?>