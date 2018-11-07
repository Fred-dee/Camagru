<?php

if (!isset($_SESSION))
    session_start();
require_once("../config/database.php");
require_once("../includes/functions.php");
if (isset($_POST)) {
    $pdo = DB::getConnection();
    if (!isset($_POST["reset"])) {
        $bool = intval($_POST["em_subs"]);
        $stmt = $pdo->prepare("UPDATE users SET first_name = :fname, last_name = :lname, email = :email, em_subs = :sub WHERE user_name = :uname");
        $stmt->bindParam(':fname', $_POST["first_name"], PDO::PARAM_STR, 25);
        $stmt->bindParam(':lname', $_POST["last_name"], PDO::PARAM_STR, 25);
        $stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
        $stmt->bindParam(':uname', $_SESSION["login"], PDO::PARAM_STR, 25);
        $stmt->bindParam(':sub', $bool, PDO::PARAM_INT);
        if ($stmt->execute()) {
            valid_success(-1, "Your information has been updated succesfully", "/profile");
        } else
            profile_error(-1, "Could not update your profile");
    }
    else {
        if ($_POST["reset"] == "update") {
            $stmt = $pdo->prepare("SELECT hash FROM users WHERE user_name=:uname");
            $stmt->bindParam(':uname', $_SESSION["login"], PDO::PARAM_STR);
            try {
                $stmt->execute();

                $hash = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($hash && password_verify($_POST["psswd"], $hash["hash"])) {
                    if ($_POST["npsswd"] == $_POST["npsswdc"]) {
                        $pass = htmlspecialchars($_POST["npsswd"]);
                        $stmt = $pdo->prepare("UPDATE users SET hash=:nhash WHERE user_name = :uname");
                        $stmt->bindParam(":nhash", password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
                        $stmt->bindParam(":uname", $_SESSION["login"]);
                        $stmt->execute();
                        valid_success(-1, "You've succesfully updated your password", "/profile");
                    } else
                        general_error(-1, "The new passwords you have entered do not match.", "/forgot");
                } else
                    general_error(-1, "Incorrect Password", "/forgot");
            } catch (\PDOException $e) {
                general_error((int) $e->getCode(), $e->getMessage(), "/forgot");
            }
        } elseif ($_POST["reset"] == "reset") {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name=:uname");
            $stmt->bindParam(':uname', $_POST["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
                if ($stmt->rowCount() == 1) {
                    if ($_POST["npsswd"] == $_POST["npsswdc"]) {
                        $pass = htmlspecialchars($_POST["npsswd"]);
                        $stmt = $pdo->prepare("UPDATE users SET hash=:nhash WHERE user_name = :uname");
                        $stmt->bindParam(":nhash", password_hash($pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
                        $stmt->bindParam(":uname", $_POST["username"]);
                        $stmt->execute();
                        valid_success(-1, "You've succesfully updated your password", "/index");
                    } else
                        general_error(-1, "The new passwords you have entered do not match.", "/forgot");
                } else
                    general_error(-1, "Invalid Username", "/forgot");
            } catch (\PDOexception $e) {
                general_error((int) $e->getCode(), $e->getMessage(), "/forgot");
            }
        }
    }
}
?>