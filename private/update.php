<?php
if(!isset($_SESSION))
    session_start();
require_once("../config/database.php");
require_once("../includes/functions.php");
if(isset($_POST))
{
    $pdo = DB::getConnection();
    $bool = intval($_POST["em_subs"]);
    $stmt = $pdo->prepare("UPDATE users SET first_name = :fname, last_name = :lname, email = :email, em_subs = :sub WHERE user_name = :uname");
    $stmt->bindParam(':fname', $_POST["first_name"], PDO::PARAM_STR, 25);
    $stmt->bindParam(':lname', $_POST["last_name"], PDO::PARAM_STR, 25);
    $stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
    $stmt->bindParam(':uname', $_SESSION["login"], PDO::PARAM_STR, 25);
    $stmt->bindParam(':sub', $bool, PDO::PARAM_INT);
    if($stmt->execute())
    {
        valid_success(-1, "Your information has been updated succesfully", "/profile");
    }
    else
        profile_error(-1, "Could not update your profile");
}
?>