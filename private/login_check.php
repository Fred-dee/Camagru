<?php
//$generatedKey = sha1(mt_rand(10000,99999).time().$email);
if (!isset($_SESSION))
    session_start();
require_once("../config/database.php");
require_once("../includes/functions.php");

$pdo = DB::getConnection();
if ($pdo == null)
    login_error(-1, "Could not obtain a pdo object");
if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "Register") {
        $fname = htmlspecialchars($_POST["s_fname"]);
        $lname = htmlspecialchars($_POST["s_lname"]);
        $email = htmlspecialchars($_POST["s_email"]);
        $password = htmlspecialchars($_POST["s_password"]);
        $cpass = htmlspecialchars($_POST["s_cpassword"]);
        $username = htmlspecialchars($_POST["s_username"]);
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        
        $verification_code;

        if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            login_error(1, "Password should contain at least one upper case, one lowercase one digit and a special character. Password must be of length 8 and above");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name= ?");
            $stmt->execute([$username]);
            $numrows = $stmt->rowCount();
            if ($numrows != 0) {
                login_error(1, "Username already exists");
            } else {
                if (cpass != password) {
                    login_error(1, "Passwords do not match");
                } else {
                    $hashed = password_hash($password, PASSWORD_DEFAULT);
                    $now = new DateTime();
                    $verification_code = password_hash($username.$email.$fname.$now->format('Y-m-d-H-i-s'), PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("INSERT INTO users (`user_name`, `first_name`, `last_name`, `email`, `hash`, `verification_key`) VALUES
                        (:uname, :fname, :lname, :email, :hash, :veri)
                        ");
                    $stmt->bindParam(':uname', $username, PDO::PARAM_STR, 15);
                    $stmt->bindParam(':fname', $fname, PDO::PARAM_STR, 25);
                    $stmt->bindParam(':lname', $lname, PDO::PARAM_STR, 25);
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                    $stmt->bindParam(':hash', $hashed, PDO::PARAM_STR);
                    $stmt->bindParam(':veri', $verification_code, PDO::PARAM_STR);
                    try {
                        $stmt->execute();
                        $_SESSION["login"] = $username;
                        $stmt = $pdo->prepare("SELECT id FROM users WHERE user_name=:uname");
                        $stmt->bindParam(':uname', $username, PDO::PARAM_STR, 15);
                        $stmt->execute();
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION["user_id"] = (int) $row["id"];
                        
                        /*
                         * Remember to send out an email here with verification auth details
                         */
                        header("location: ../index");
                        exit();
                    } catch (PDOException $e) {
                        login_error(1, $e->getMessage());
                    }
                }
            }
        }
    }
    if ($_POST["submit"] == "Login") {

        $username = htmlspecialchars($_POST["lusername"]);
        $rawpassword = htmlspecialchars($_POST["lpassword"]);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :uname");
        $stmt->bindParam(':uname', $username, PDO::PARAM_STR, 15);
        try {
            $stmt->execute();
            $numRows = $stmt->rowCount();
            if ($numRows == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($rawpassword, $row["hash"])) {
                    if ($row["verified"] == 0)
                        login_error(0, "Please follow the link in your mail to verify your account [Mail might be in spam folder]");
                    $_SESSION["login"] = $username;
                    $_SESSION["user_id"] = (int) $row["id"];
                    header("location: ../index");
                    exit();
                } else
                    login_error(0, "Username/Password entered does not match any known users");
            }
            else {
                login_error(0, "Username/Password entered does not match any known users");
            }
        } catch (PDOException $e) {
            login_error(0, $e->getMessage());
        }
    }
}
?>