<?php
if(!isset($_SESSION))
    session_start();
require_once("../config/database.php");
require_once("../includes/functions.php");
if(isset($_POST))
{
    $pdo = DB::getConnection();
    $stmt = $pdo->prepare("UPDATE users SET first_name = :fname, last_name = :lname, email = :email WHERE user_name = :uname");
    $stmt->bindParam(':fname', $_POST["first_name"], PDO::PARAM_STR, 25);
    $stmt->bindParam(':lname', $_POST["last_name"], PDO::PARAM_STR, 25);
    $stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
    $stmt->bindParam(':uname', $_SESSION["login"], PDO::PARAM_STR, 25);
    if($stmt->execute())
        header("location: ../profile");
    else
        profile_error(-1, "Could not update your profile");
}
?>